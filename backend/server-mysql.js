const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const compression = require('compression');
const morgan = require('morgan');
const rateLimit = require('express-rate-limit');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
require('dotenv').config();

const config = require('./src/config/config');
const { initDatabase, testDatabaseConnection, sequelize } = require('./src/config/init-database');

// Import models
const User = require('./src/models/User-cjs');
const Agent = require('./src/models/Agent-cjs');
const Customer = require('./src/models/Customer-cjs');
const Project = require('./src/models/Project-cjs');

const app = express();

// Security middleware
app.use(helmet({
  crossOriginEmbedderPolicy: false,
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'"],
      styleSrc: ["'self'", "'unsafe-inline'"],
      scriptSrc: ["'self'"],
      imgSrc: ["'self'", "data:", "https:"],
    },
  },
}));

// CORS
app.use(cors(config.cors));

// Rate limiting (disabled for development)
if (config.server.nodeEnv === 'production') {
  const limiter = rateLimit({
    windowMs: config.rateLimit.windowMs,
    max: config.rateLimit.maxRequests,
    message: {
      success: false,
      message: 'มีการร้องขอมากเกินไป กรุณาลองใหม่ในภายหลัง'
    },
    standardHeaders: true,
    legacyHeaders: false,
  });
  app.use('/api/', limiter);
}

// Body parsing middleware
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Compression
app.use(compression());

// Logging
if (config.server.nodeEnv === 'development') {
  app.use(morgan('dev'));
}

// Health check endpoint
app.get('/health', (req, res) => {
  res.json({
    success: true,
    message: 'Server is running',
    timestamp: new Date().toISOString(),
    environment: config.server.nodeEnv
  });
});

// Basic API routes
app.get('/api', (req, res) => {
  res.json({
    success: true,
    message: 'Agent Referral System API - MySQL Edition',
    version: '1.0.0',
    endpoints: {
      health: '/health',
      auth: '/api/auth/*',
      agents: '/api/agents/*',
      customers: '/api/customers/*',
      projects: '/api/projects/*'
    }
  });
});

// Test database connection endpoint
app.get('/api/test-db', async (req, res) => {
  try {
    const isConnected = await testDatabaseConnection();
    if (isConnected) {
      res.json({
        success: true,
        message: 'Database connection successful'
      });
    } else {
      res.status(500).json({
        success: false,
        message: 'Database connection failed'
      });
    }
  } catch (error) {
    res.status(500).json({
      success: false,
      message: 'Database connection failed',
      error: error.message
    });
  }
});

// JWT helper functions
const generateToken = (user) => {
  return jwt.sign(
    {
      id: user.id,
      email: user.email,
      role: user.role
    },
    process.env.JWT_SECRET || 'dev-secret-sena-referral-2024',
    { expiresIn: '24h' }
  );
};

const verifyToken = (token) => {
  return jwt.verify(token, process.env.JWT_SECRET || 'dev-secret-sena-referral-2024');
};

// Auth middleware
const checkAuth = async (req, res, next) => {
  try {
    const authHeader = req.headers.authorization;

    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      return res.status(401).json({
        success: false,
        message: 'ไม่พบ Token การเข้าถึงถูกปฏิเสธ'
      });
    }

    const token = authHeader.split(' ')[1];
    const decoded = verifyToken(token);

    // Get user from database
    const user = await User.findByPk(decoded.id);
    if (!user || !user.isActive) {
      return res.status(401).json({
        success: false,
        message: 'Token ไม่ถูกต้องหรือผู้ใช้ถูกระงับ'
      });
    }

    req.user = user;
    next();
  } catch (error) {
    return res.status(401).json({
      success: false,
      message: 'Token ไม่ถูกต้อง'
    });
  }
};

// ==================== AUTH ENDPOINTS ====================

// Login endpoint
app.post('/api/auth/login', async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({
        success: false,
        message: 'กรุณาป้อนอีเมลและรหัสผ่าน'
      });
    }

    // Find user in database
    const user = await User.findOne({ where: { email } });

    if (!user) {
      return res.status(401).json({
        success: false,
        message: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
      });
    }

    // Check password
    const isPasswordValid = await user.comparePassword(password);

    if (!isPasswordValid) {
      return res.status(401).json({
        success: false,
        message: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
      });
    }

    // Check if user is active
    if (!user.isActive) {
      return res.status(403).json({
        success: false,
        message: 'บัญชีของคุณถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ'
      });
    }

    // Note: lastLogin field not in current schema

    // Generate token
    const token = generateToken(user);

    // Get additional info if user is agent
    let userData = {
      id: user.id,
      email: user.email,
      role: user.role
    };

    if (user.role === 'agent') {
      const agent = await Agent.findOne({ where: { userId: user.id } });
      if (agent) {
        if (agent.status === 'inactive') {
          return res.status(403).json({
            success: false,
            message: 'บัญชีของคุณยังไม่ได้รับการอนุมัติ กรุณารอการอนุมัติจากผู้ดูแลระบบ'
          });
        }

        userData = {
          ...userData,
          agentId: agent.id,
          agentCode: agent.agentCode,
          firstName: agent.firstName,
          lastName: agent.lastName
        };
      }
    }

    res.json({
      success: true,
      message: 'เข้าสู่ระบบสำเร็จ',
      data: {
        user: userData,
        token
      }
    });

  } catch (error) {
    console.error('Login error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ'
    });
  }
});

// Get current user endpoint
app.get('/api/auth/me', checkAuth, async (req, res) => {
  try {
    const user = req.user;
    let userData = {
      id: user.id,
      email: user.email,
      role: user.role
    };

    if (user.role === 'agent') {
      const agent = await Agent.findOne({ where: { userId: user.id } });
      if (agent) {
        userData = {
          ...userData,
          agentId: agent.id,
          agentCode: agent.agentCode,
          firstName: agent.firstName,
          lastName: agent.lastName,
          status: agent.status
        };
      }
    }

    res.json({
      success: true,
      message: 'ดึงข้อมูลผู้ใช้สำเร็จ',
      data: userData
    });

  } catch (error) {
    console.error('Get user error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการดึงข้อมูลผู้ใช้'
    });
  }
});

// Logout endpoint
app.post('/api/auth/logout', (req, res) => {
  res.json({
    success: true,
    message: 'ออกจากระบบสำเร็จ'
  });
});

// Register agent endpoint
app.post('/api/auth/register-agent', async (req, res) => {
  try {
    console.log('=== Register Agent Request ===');
    console.log('Request Body:', req.body);

    const {
      firstName,
      lastName,
      email,
      phone,
      idCard,
      password
    } = req.body;

    // Basic validation
    if (!firstName || !lastName || !email || !idCard || !password) {
      return res.status(400).json({
        success: false,
        message: 'กรุณากรอกข้อมูลให้ครบถ้วน'
      });
    }

    // Check if email already exists
    const existingUser = await User.findOne({ where: { email } });
    if (existingUser) {
      return res.status(400).json({
        success: false,
        message: 'อีเมลนี้ถูกใช้แล้ว',
        errorType: 'email'
      });
    }

    // Check if ID card already exists
    const existingAgent = await Agent.findOne({ where: { idCard } });
    if (existingAgent) {
      return res.status(400).json({
        success: false,
        message: 'เลขประจำตัวประชาชนนี้ถูกใช้แล้ว',
        errorType: 'idCard'
      });
    }

    // Check for duplicate phone (if provided)
    if (phone) {
      const existingPhone = await Agent.findOne({ where: { phone } });
      if (existingPhone) {
        return res.status(400).json({
          success: false,
          message: 'เบอร์โทรนี้ถูกใช้แล้ว',
          errorType: 'phone'
        });
      }
    }

    // Generate new agent code
    const existingAgents = await Agent.findAll({ order: [['agentCode', 'DESC']] });
    const existingCodes = existingAgents.map(a => a.agentCode);
    let newAgentCode;
    let codeNumber = 1;

    do {
      newAgentCode = `AG${String(codeNumber).padStart(3, '0')}`;
      codeNumber++;
    } while (existingCodes.includes(newAgentCode));

    // Create user first
    const newUser = await User.create({
      email,
      password,
      role: 'agent'
    });

    // Create agent
    const newAgent = await Agent.create({
      userId: newUser.id,
      agentCode: newAgentCode,
      firstName,
      lastName,
      phone: phone || '',
      idCard,
      registrationDate: new Date().toISOString().split('T')[0],
      status: 'inactive' // Agent needs admin approval
    });

    res.status(201).json({
      success: true,
      message: 'ลงทะเบียนสำเร็จ รอการอนุมัติจากผู้ดูแลระบบ',
      data: {
        agentCode: newAgent.agentCode,
        firstName: newAgent.firstName,
        lastName: newAgent.lastName,
        email: newUser.email,
        status: newAgent.status
      }
    });

  } catch (error) {
    console.error('Register agent error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการลงทะเบียน'
    });
  }
});

// ==================== AGENTS ENDPOINTS ====================

// GET /api/agents - Get all agents
app.get('/api/agents', checkAuth, async (req, res) => {
  try {
    const { page = 1, limit = 10, status, search } = req.query;

    let whereCondition = {};

    // Filter by status
    if (status && status !== 'all') {
      whereCondition.status = status;
    }

    // Search by name or agent code
    if (search) {
      const { Op } = require('sequelize');
      whereCondition[Op.or] = [
        { firstName: { [Op.like]: `%${search}%` } },
        { lastName: { [Op.like]: `%${search}%` } },
        { agentCode: { [Op.like]: `%${search}%` } }
      ];
    }

    const offset = (page - 1) * limit;

    const { count, rows: agents } = await Agent.findAndCountAll({
      where: whereCondition,
      include: [
        {
          model: User,
          attributes: ['email'],
          required: false
        }
      ],
      limit: parseInt(limit),
      offset: offset,
      order: [['createdAt', 'DESC']]
    });

    res.json({
      success: true,
      message: 'ดึงข้อมูลเอเจนต์สำเร็จ',
      data: agents,
      pagination: {
        current: parseInt(page),
        pageSize: parseInt(limit),
        total: count,
        totalPages: Math.ceil(count / limit)
      }
    });

  } catch (error) {
    console.error('Get agents error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการดึงข้อมูลเอเจนต์'
    });
  }
});

// GET /api/agents/list - Get agents list for dropdown
app.get('/api/agents/list', checkAuth, async (req, res) => {
  try {
    const agents = await Agent.findAll({
      where: { status: 'active' },
      attributes: ['id', 'agentCode', 'firstName', 'lastName'],
      order: [['agentCode', 'ASC']]
    });

    const agentsList = agents.map(agent => ({
      id: agent.id,
      agentCode: agent.agentCode,
      firstName: agent.firstName,
      lastName: agent.lastName,
      fullName: `${agent.agentCode} - ${agent.firstName} ${agent.lastName}`
    }));

    res.json({
      success: true,
      message: 'ดึงรายชื่อเอเจนต์สำเร็จ',
      data: agentsList
    });

  } catch (error) {
    console.error('Get agents list error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการดึงรายชื่อเอเจนต์'
    });
  }
});

// GET /api/agents/:id - Get agent by ID
app.get('/api/agents/:id', checkAuth, async (req, res) => {
  try {
    const { id } = req.params;

    const agent = await Agent.findByPk(id, {
      include: [
        {
          model: User,
          attributes: ['email'],
          required: false
        }
      ]
    });

    if (!agent) {
      return res.status(404).json({
        success: false,
        message: 'ไม่พบข้อมูลเอเจนต์'
      });
    }

    res.json({
      success: true,
      message: 'ดึงข้อมูลเอเจนต์สำเร็จ',
      data: agent
    });

  } catch (error) {
    console.error('Get agent error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการดึงข้อมูลเอเจนต์'
    });
  }
});

// PUT /api/agents/:id - Update agent
app.put('/api/agents/:id', checkAuth, async (req, res) => {
  try {
    const { id } = req.params;
    const { firstName, lastName, phone, status } = req.body;

    const agent = await Agent.findByPk(id);

    if (!agent) {
      return res.status(404).json({
        success: false,
        message: 'ไม่พบข้อมูลเอเจนต์'
      });
    }

    // Update agent
    await agent.update({
      ...(firstName && { firstName }),
      ...(lastName && { lastName }),
      ...(phone && { phone }),
      ...(status && { status })
    });

    // Get updated agent with user info
    const updatedAgent = await Agent.findByPk(id, {
      include: [
        {
          model: User,
          attributes: ['email'],
          required: false
        }
      ]
    });

    res.json({
      success: true,
      message: 'อัพเดทข้อมูลเอเจนต์สำเร็จ',
      data: updatedAgent
    });

  } catch (error) {
    console.error('Update agent error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลเอเจนต์'
    });
  }
});

// PUT /api/agents/profile - Update agent's own profile
app.put('/api/agents/profile', checkAuth, async (req, res) => {
  try {
    // Only agents can update their own profile
    if (req.user.role !== 'agent') {
      return res.status(403).json({
        success: false,
        message: 'เฉพาะเอเจนต์เท่านั้นที่สามารถแก้ไขข้อมูลส่วนตัวได้'
      });
    }

    const agent = await Agent.findOne({ where: { userId: req.user.id } });

    if (!agent) {
      return res.status(404).json({
        success: false,
        message: 'ไม่พบข้อมูลเอเจนต์'
      });
    }

    const { phone } = req.body;

    // Agents can only update their phone number
    await agent.update({ phone: phone || '' });

    res.json({
      success: true,
      message: 'อัพเดทเบอร์โทรสำเร็จ',
      data: {
        id: req.user.id,
        email: req.user.email,
        role: 'agent',
        agentId: agent.id,
        agentCode: agent.agentCode,
        firstName: agent.firstName,
        lastName: agent.lastName,
        phone: agent.phone,
        status: agent.status
      }
    });

  } catch (error) {
    console.error('Update agent profile error:', error);
    res.status(500).json({
      success: false,
      message: 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลส่วนตัว'
    });
  }
});

// Setup associations
User.hasOne(Agent, { foreignKey: 'userId' });
Agent.belongsTo(User, { foreignKey: 'userId' });

Customer.belongsTo(Agent, { foreignKey: 'agentId' });
Agent.hasMany(Customer, { foreignKey: 'agentId' });

Customer.belongsTo(Project, { foreignKey: 'projectId' });
Project.hasMany(Customer, { foreignKey: 'projectId' });

// 404 handler
app.use('*', (req, res) => {
  res.status(404).json({
    success: false,
    message: 'ไม่พบ API endpoint ที่ต้องการ'
  });
});

// Global error handler
app.use((error, req, res, next) => {
  console.error('Global error handler:', error);

  res.status(500).json({
    success: false,
    message: 'เกิดข้อผิดพลาดของเซิร์ฟเวอร์',
    ...(config.server.nodeEnv === 'development' && { error: error.message })
  });
});

// Start server
const startServer = async () => {
  try {
    // Initialize database connection
    await initDatabase();

    const server = app.listen(config.server.port, () => {
      console.log(`🚀 Server running on http://${config.server.host}:${config.server.port}`);
      console.log(`📊 Environment: ${config.server.nodeEnv}`);
      console.log(`🔗 API Base URL: http://${config.server.host}:${config.server.port}/api`);
      console.log(`🏥 Health Check: http://${config.server.host}:${config.server.port}/health`);
      console.log(`🗄️ Database: MySQL connected`);
    });

    // Graceful shutdown
    process.on('SIGTERM', () => {
      console.log('SIGTERM received. Shutting down gracefully...');
      server.close(() => {
        console.log('Process terminated');
        process.exit(0);
      });
    });

    process.on('SIGINT', () => {
      console.log('SIGINT received. Shutting down gracefully...');
      server.close(() => {
        console.log('Process terminated');
        process.exit(0);
      });
    });

  } catch (error) {
    console.error('Failed to start server:', error);
    process.exit(1);
  }
};

startServer();