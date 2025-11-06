const express = require('express');
const cors = require('cors');
const app = express();

// ✅ CORS middleware with explicit OPTIONS support
app.use(cors({
  origin: 'http://172.22.22.11:3000',
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization']
}));

// ✅ Explicit OPTIONS handler for preflight requests
app.options('*', (req, res) => {
  res.header('Access-Control-Allow-Origin', 'http://172.22.22.11:3000');
  res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
  res.header('Access-Control-Allow-Credentials', 'true');
  res.send(204);
});

// middleware อื่นๆ
app.use(express.json());
// ... rest of your code


