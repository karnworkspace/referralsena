# SENA Agent Referral System

ระบบจัดการเอเจนต์และการแนะนำลูกค้า สำหรับธุรกิจอสังหาริมทรัพย์ พร้อมระบบติดตามการเปลี่ยนแปลงข้อมูลแบบอัตโนมัติ

## 🚀 Tech Stack

- **Frontend**: React 18 + Vite + Ant Design
- **Backend**: Node.js + Express.js + Sequelize ORM
- **Database**: MySQL 8.0 with Docker
- **Authentication**: JWT (JSON Web Token)
- **Deployment**: Docker + Docker Compose
- **Activity Logging**: MySQL Triggers + JSON Storage

## 📁 Project Structure

```
Projectrefer/
├── backend/                 # Node.js Backend API
│   ├── server-mysql.js      # Main server file (MySQL + Sequelize)
│   ├── config/              # Database configuration
│   ├── models/              # Sequelize models (Users, Agents, Customers, Projects)
│   └── uploads/             # File uploads directory
├── frontend/                # React Frontend
│   ├── src/
│   │   ├── pages/           # Main pages (Dashboard, AgentManagement, CustomerManagement, ProjectManagement)
│   │   ├── components/      # Reusable components
│   │   │   └── charts/      # Dashboard charts (StatisticsBarChart, CustomerStatusPieChart, TrendLineChart, PerformanceAreaChart)
│   │   ├── store/           # Redux slices (auth, agents, customers, projects)
│   │   └── services/        # API services
│   ├── public/              # Static assets
│   └── package.json         # Dependencies (React 18, Vite, Ant Design, Redux Toolkit)
├── database-schema.sql      # Complete database schema
├── docker-compose.yml       # Docker configuration (MySQL, API, Frontend, phpMyAdmin)
├── CLAUDE.md               # Project memory & context
└── README.md               # This file
```

## 🐳 Quick Start with Docker (แนะนำ)

### Prerequisites
- Docker Desktop
- Git

### เริ่มต้นใช้งาน

1. **Clone repository**
   ```bash
   git clone https://github.com/karnworkspace/referralsena.git
   cd referralsena
   ```

2. **เริ่มต้นระบบทั้งหมด**
   ```bash
   docker-compose up -d
   ```

3. **เข้าใช้งานระบบ**
   - Frontend: http://localhost:3000
   - Backend API: http://localhost:4000
   - Database: localhost:3306

4. **ข้อมูลการเข้าสู่ระบบ**
   ```json
   {
     "email": "admin@test.com",
     "password": "password"
   }
   ```

### 📊 Services ที่รันอยู่
- **MySQL Database**: `sena_mysql` container (port 3306)
- **Backend API**: `sena_api` container (port 4000)
- **Frontend Web**: `sena_web` container (port 3000)
- **Database GUI**: `sena_phpmyadmin` container (port 8080)

## 🔐 Role Management & Permissions

ระบบ SENA Agent มี **2 Roles** หลักในการจัดการสิทธิ์การใช้งาน:

### 👑 **Admin (ผู้ดูแลระบบ)**

**สิทธิ์**: Full Access ทุกฟีเจอร์ในระบบ

**หน้าที่เข้าถึง**:
- **`/admin/dashboard`** - แดชบอร์ดหลักพร้อม charts และสถิติครบถ้วน
- **Agent Management** - จัดการเอเจนต์ทุกคน (CRUD)
- **Customer Management** - จัดการลูกค้าทุกคน (CRUD)
- **Project Management** - จัดการโครงการอสังหาริมทรัพย์ (CRUD)
- **Reports** - เมนูสำหรับดูรายงานต่างๆ

**ฟีเจอร์พิเศษ**:
- ✅ อนุมัติ/ปฏิเสธเอเจนต์ใหม่
- ✅ ดูข้อมูลทั้งหมดในระบบ
- ✅ เปลี่ยนสถานะได้ทุกอย่าง
- ✅ มองเห็นสถิติรวม (Dashboard Charts, Statistics, Activities)
- ✅ จัดการ projects และ price ranges

### 👤 **Agent (เอเจนต์)**

**สิทธิ**: Limited Access - เฉพาะข้อมูลตัวเอง

**หน้าที่เข้าถึง**:
- **`/agent/dashboard`** - แดชบอร์ดเฉพาะข้อมูลของตัวเอง
- **Profile Management** - ดู/แก้ไขข้อมูลส่วนตัว
- **Customer View** - ดูเฉพาะลูกค้าที่ตัวเองรับผิดชอบ

**ฟีเจอร์ที่ทำได้**:
- ✅ ดูรายชื่อลูกค้าของตัวเอง
- ✅ แก้ไขเบอร์โทรศัพท์และข้อมูลส่วนตัว
- ✅ ดูสถิติส่วนตัว (ยอดลูกค้า, ยอดขาย)
- ❌ ไม่สามารถจัดการเอเจนต์คนอื่น
- ❌ ไม่สามารถจัดการลูกค้าคนอื่น
- ❌ ไม่สามารถจัดการโครงการ

### 🔐 **ระบบความปลอดภัย (Security Features)**

- **Route Protection**: ตรวจสอบสิทธิ์ก่อนเข้าหน้าต่างๆ (ProtectedRoute/PublicRoute)
- **API Authentication**: Bearer Token สำหรับทุกการเรียก API
- **Data Filtering**: Backend กรองข้อมูลตาม `agentId` ของตัวเอง
- **Auto Logout**: ทำอัตโนมัติเมื่อ token หมดอายุ (401 Unauthorized)
- **Session Management**: Token เก็บใน localStorage

### 📱 **User Experience แยกตาม Role**

- **Admin UI**: แสดง "ผู้ดูแลระบบ" พร้อมเมนูครบถ้วน
- **Agent UI**: แสดง "เอเจนต์" พร้อมรหัสเอเจนต์ (เช่น AG007)
- **Dashboard Layout**: Admin ดูข้อมูลรวม, Agent ดูเฉพาะข้อมูลตัวเอง

## 🗄️ Database Setup และ Activity Logging

### MySQL Database

ระบบใช้ **MySQL 8.0** พร้อม **Docker** สำหรับ:
- ✅ **Auto-initialization** - สร้างตารางและข้อมูลตัวอย่างอัตโนมัติ
- ✅ **Activity Logging** - บันทึกการเปลี่ยนแปลงข้อมูลลูกค้าทุกครั้ง
- ✅ **Data Persistence** - ข้อมูลไม่หายเมื่อ restart container
- ✅ **Backup/Restore** - สำรองและกู้คืนข้อมูลได้ง่าย

### 🔄 Activity Logging System

#### การทำงานของ Activity Logs

ระบบติดตามการเปลี่ยนแปลงข้อมูลลูกค้าโดยอัตโนมัติผ่าน **MySQL Triggers**:

1. **เมื่อสร้างลูกค้าใหม่** → บันทึก log ประเภท `CREATE`
2. **เมื่อแก้ไขข้อมูล** → บันทึก log ประเภท `UPDATE` พร้อม before/after values
3. **เมื่อลบข้อมูล** → บันทึก log ประเภท `DELETE`

#### ตัวอย่างข้อมูล Activity Log

```sql
-- ดูประวัติการเปลี่ยนแปลงของลูกค้า ID = 1
SELECT * FROM customer_history WHERE customer_id = 1;

-- ดูการเปลี่ยนแปลงสถานะลูกค้า
SELECT
    customer_name,
    JSON_UNQUOTE(JSON_EXTRACT(old_values, '$.status')) as old_status,
    JSON_UNQUOTE(JSON_EXTRACT(new_values, '$.status')) as new_status,
    changed_by,
    created_at
FROM customer_history
WHERE action = 'UPDATE'
AND JSON_EXTRACT(old_values, '$.status') != JSON_EXTRACT(new_values, '$.status');
```

#### Database Schema สำหรับ Activity Logging

```sql
-- ตาราง activity_logs เก็บการเปลี่ยนแปลงทั้งหมด
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,                     -- ใครเป็นคนแก้ไข
    action VARCHAR(50) NOT NULL,     -- CREATE, UPDATE, DELETE
    table_name VARCHAR(50) NOT NULL, -- ตารางที่แก้ไข
    record_id INT NOT NULL,          -- ID ของ record ที่แก้ไข
    old_values JSON,                 -- ข้อมูลก่อนแก้ไข (JSON format)
    new_values JSON,                 -- ข้อมูลหลังแก้ไข (JSON format)
    ip_address VARCHAR(45),          -- IP address
    user_agent TEXT,                 -- Browser info
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- View สำหรับดู history ของลูกค้าแต่ละคน
CREATE VIEW customer_history AS
SELECT
    al.id,
    al.action,
    al.record_id as customer_id,
    CONCAT(c.first_name, ' ', c.last_name) as customer_name,
    u.email as changed_by,
    al.old_values,
    al.new_values,
    al.created_at
FROM activity_logs al
LEFT JOIN customers c ON al.record_id = c.id
LEFT JOIN users u ON al.user_id = u.id
WHERE al.table_name = 'customers'
ORDER BY al.created_at DESC;
```

### 🛠️ Manual Setup (สำหรับ Development)

หากต้องการ setup แบบ manual (ไม่ใช้ Docker):

1. **ติดตั้ง Dependencies**
   ```bash
   cd backend && npm install
   cd ../frontend && npm install
   ```

2. **สร้าง MySQL Database**
   ```sql
   CREATE DATABASE sena_referral CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import Database Schema**
   ```bash
   mysql -u root -p sena_referral < database-schema.sql
   ```

4. **เริ่มต้น Services**
   ```bash
   # Terminal 1: Backend
   cd backend && node server-mysql.js

   # Terminal 2: Frontend
   cd frontend && npm run dev
   ```

**⚠️ หมายเหตุ**: แนะนำให้ใช้ Docker เพื่อความสะดวกและความสม่ำเสมอของ environment

## 🔌 API Endpoints

### Health Check
- `GET /health` - ตรวจสอบสถานะเซิร์ฟเวอร์
- `GET /api` - ข้อมูล API endpoints
- `GET /api/test-db` - ทดสอบการเชื่อมต่อฐานข้อมูล

### Authentication
- `POST /api/auth/login` - เข้าสู่ระบบ
- `POST /api/auth/register-agent` - ลงทะเบียนเอเจนต์
- `GET /api/auth/me` - ข้อมูลผู้ใช้ปัจจุบัน
- `POST /api/auth/logout` - ออกจากระบบ

### Agents Management
- `GET /api/agents` - ดึงรายการเอเจนต์ทั้งหมด (Admin เท่านั้น)
- `GET /api/agents/list` - ดึงรายชื่อเอเจนต์สำหรับ dropdown
- `GET /api/agents/:id` - ดึงข้อมูลเอเจนต์ตาม ID
- `GET /api/agents/next-code` - ดึงรหัสเอเจนต์ถัดไป (Auto increment)
- `POST /api/agents` - สร้างเอเจนต์ใหม่ (Admin เท่านั้น)
- `PUT /api/agents/:id` - อัพเดทข้อมูลเอเจนต์ (Admin เท่านั้น)
- `PUT /api/agents/profile` - แก้ไขข้อมูลส่วนตัว (Agent เท่านั้น)
- `PUT /api/agents/:id/approve` - อนุมัติเอเจนต์ (Admin เท่านั้น)
- `PUT /api/agents/:id/reject` - ปฏิเสธเอเจนต์ (Admin เท่านั้น)

### Customers Management
- `GET /api/customers` - ดึงรายการลูกค้า (Admin: ทั้งหมด, Agent: เฉพาะของตัวเอง)
- `GET /api/customers/:id` - ดึงข้อมูลลูกค้าตาม ID
- `POST /api/customers` - สร้างลูกค้าใหม่ (Admin เท่านั้น)
- `PUT /api/customers/:id` - อัพเดทข้อมูลลูกค้า (Admin: ทุกคน, Agent: เฉพาะของตัวเอง)
- `DELETE /api/customers/:id` - ลบลูกค้า (Admin เท่านั้น)

### Projects Management
- `GET /api/projects` - ดึงรายการโครงการทั้งหมด
- `GET /api/projects/:id` - ดึงข้อมูลโครงการตาม ID
- `POST /api/projects` - สร้างโครงการใหม่ (Admin เท่านั้น)
- `PUT /api/projects/:id` - อัพเดทข้อมูลโครงการ (Admin เท่านั้น)
- `DELETE /api/projects/:id` - ลบโครงการ (Admin เท่านั้น)

### Dashboard Statistics
- `GET /api/dashboard/stats` - ดึงข้อมูลสถิติ Dashboard (Admin เท่านั้น)
- `GET /api/dashboard/agent-stats` - ดึงข้อมูลสถิติส่วนตัว (Agent เท่านั้น)

### 🔐 ข้อมูลการเข้าสู่ระบบ

#### Admin Account
```json
POST /api/auth/login
{
  "email": "admin@test.com",
  "password": "password"
}
```

#### Sample Agent Accounts
```json
// Agent 1
{
  "email": "agent1@test.com",
  "password": "password"
}

// Agent 2
{
  "email": "agent2@test.com",
  "password": "password"
}
```

### 📊 การใช้งาน Activity Logging

#### 1. ดูประวัติการเปลี่ยนแปลงลูกค้า
```bash
curl -X GET "http://localhost:4000/api/customers/1/history" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

#### 2. ตัวอย่างการแก้ไขข้อมูลลูกค้า (จะสร้าง activity log อัตโนมัติ)
```bash
curl -X PUT "http://localhost:4000/api/customers/1" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "firstName": "ชื่อใหม่",
    "status": "contacted"
  }'
```

#### 3. Query Database โดยตรง
```sql
-- เชื่อมต่อ MySQL
docker exec -it sena_mysql mysql -u sena_user -p sena_referral

-- ดูการเปลี่ยนแปลงล่าสุด 10 รายการ
SELECT * FROM customer_history LIMIT 10;

-- ดูการเปลี่ยนแปลงของลูกค้าคนใดคนหนึ่ง
SELECT
    action,
    old_values,
    new_values,
    changed_by,
    created_at
FROM customer_history
WHERE customer_id = 1;
```

### 🗄️ Database Schema

ระบบใช้ฐานข้อมูลดังนี้:

- **users** - ข้อมูลผู้ใช้และการยืนยันตัวตน (11 records)
- **agents** - ข้อมูลเอเจนต์ (6 records)
- **projects** - ข้อมูลโครงการอสังหาริมทรัพย์ (3 records)
- **customers** - ข้อมูลลูกค้า (6 records)
- **visits** - ข้อมูลการนัดหมายชมโครงการ (0 records)
- **sales** - ข้อมูลการขาย (0 records)
- **leads** - ข้อมูล Lead (2 records)
- **requests** - คำร้องต่างๆ (0 records)
- **activity_logs** - บันทึกการใช้งานและการเปลี่ยนแปลง

### 📋 Customer Status System

ระบบจัดการสถานะลูกค้าแบบ 3 สถานะ:

- ✅ **ใช้งาน (active)** - สีเขียว
- ❌ **ไม่ใช้งาน (inactive)** - สีแดง
- ⏳ **รออนุมัติ (pending)** - สีส้ม

### 🔧 Available Scripts

```bash
# Frontend
cd frontend && npm run dev     # เริ่ม development server
cd frontend && npm run build   # Build สำหรับ production

# Backend
cd backend && node server-mysql.js    # เริ่ม server (MySQL version)

# Docker Commands
docker-compose up -d          # เริ่มทุก containers
docker-compose down           # หยุดทุก containers
docker-compose logs -f        # ดู logs
```

### 🚨 Error Troubleshooting

#### Common Issues

1. **Docker Container Issues**
   ```bash
   docker-compose down -v && docker-compose up -d
   # Reset และเริ่มใหม่ (ข้อมูลจะหายหมด)
   ```

2. **Database Connection Error**
   - ตรวจสอบว่า MySQL container กำลังทำงาน: `docker ps`
   - ตรวจสอบว่า database ถูกสร้าง: `docker exec -it sena_mysql mysql -usena_user -psena_password -e "SHOW DATABASES;"`

3. **Port Already in Use**
   - ตรวจสอบว่า ports 3000, 4000, 3306, 8080 ว่าง
   - ใช้ `lsof -i :3000` เพื่อดูว่าใครใช้ port อยู่

4. **Frontend Not Loading**
   - ตรวจสอบว่า API server ทำงาน: `curl http://localhost:4000/health`
   - ตรวจสอบ logs: `docker-compose logs -f sena_web`

5. **API Error 500**
   - ตรวจสอบ backend logs: `docker-compose logs -f sena_api`
   - ตรวจสอบ database connection: `docker exec -it sena_mysql mysql -usena_user -psena_password sena_referral`

### 🎯 Current Features (สถานะล่าสุด)

✅ **สมบูรณ์แล้ว**:
- Authentication & Authorization (Admin/Agent Roles)
- Agent Management (CRUD + Approval System)
- Customer Management (CRUD + 3 Status System)
- Project Management (CRUD + Price Range Validation)
- Dashboard with Charts (Recharts Integration)
- Docker Infrastructure (4 Containers)
- Activity Logging & Audit Trail
- Auto-increment Agent Code System
- Database Integration (MySQL + Sequelize)

🔄 **พัฒนาต่อ**:
- Reports & Analytics
- Notification System
- File Upload Functionality
- Multi-language Support

## 📞 การติดต่อและ Support

### 🛠️ Development Tools

- **phpMyAdmin** - จัดการฐานข้อมูลผ่านเว็บ: http://localhost:8080
  - Server: `sena_mysql`
  - Username: `sena_user`
  - Password: `sena_password`
  - Database: `sena_referral`

### 📚 เอกสารเพิ่มเติม

- **CLAUDE.md** - Project memory และ context ฉบับละเอียด
- **note.md** - Configuration และคำสั่งสำคัญ
- **database-schema.sql** - โครงสร้างฐานข้อมูลฉบับเต็ม

### 🔄 Git Repository

- **Remote**: `https://github.com/karnworkspace/referralsena.git`
- **Branch**: `ver2` (Development branch)
- **Status**: Active development

## 📄 License

This project is licensed under the MIT License.

---

*อัพเดตล่าสุด: 2025-10-16 - Role Management & Permissions Documentation*