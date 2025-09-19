# CLAUDE.md - Project Memory & Context

## 📋 Project Overview
- **Project**: SENA Agent - ระบบจัดการเอเจนต์และลูกค้า
- **Tech Stack**: React + Node.js + MySQL + Docker
- **Main Features**: Dashboard, Agent Management, Customer Management, Project Management

## 🚀 Recent Completed Tasks

### 1. Dashboard Charts Implementation ✅
- เพิ่ม Recharts library
- สร้าง 4 chart components:
  - StatisticsBarChart (agent/customer comparison)
  - CustomerStatusPieChart (status distribution)
  - TrendLineChart (monthly trends)
  - PerformanceAreaChart (weekly performance)
- ย้าย charts ไปด้านบนสุดของ dashboard
- ปรับขนาดจาก 400px เป็น 280px

### 2. Agent Management Enhancements ✅
- เพิ่มระบบอนุมัติ/ปฏิเสธ agent ที่รออนุมัติ
- เพิ่ม CheckOutlined/CloseOutlined icons พร้อม Popconfirm
- ปรับ button alignment ใน action column
- เพิ่ม agent detail modal (คลิกรหัส agent เพื่อดูรายละเอียด)
- แก้ปัญหา click event redirect โดยเปลี่ยนจาก onClick เป็น onMouseDown
- ปรับ layout ให้เหมือน customer management (single Card wrapper)

### 3. Customer Status Simplification ✅
- **ลดสถานะจาก 9 เป็น 3 สถานะ:**
  - ใช้งาน (active) - สีเขียว
  - ไม่ใช้งาน (inactive) - สีแดง
  - รออนุมัติ (pending) - สีส้ม
- อัพเดต dropdown filter และ form selections
- อัพเดต statusMap ใน CustomerManagement.jsx

### 4. Customer Form Bug Fix ✅
- แก้ปัญหา registrationDate field ใน edit mode
- เปลี่ยน validation rules: required เฉพาะตอนเพิ่มใหม่
- แก้ date format เป็น YYYY-MM-DD สำหรับ input type="date"

## 🏗️ Project Structure
```
/frontend/src/
├── pages/
│   ├── Dashboard.jsx (main dashboard with charts)
│   ├── AgentManagementNew.jsx (agent CRUD + approval system)
│   └── CustomerManagement.jsx (customer CRUD with 3 status)
├── components/charts/
│   ├── StatisticsBarChart.jsx
│   ├── CustomerStatusPieChart.jsx
│   ├── TrendLineChart.jsx
│   └── PerformanceAreaChart.jsx
└── store/ (Redux slices)

/backend/
├── server-mysql.js
└── API endpoints for agents/customers
```

## 🔧 Development Commands
```bash
# Frontend
cd frontend && npm run dev

# Backend
cd backend && node server-mysql.js

# Docker
docker-compose up -d --build
```

## 🐛 Known Issues & Solutions

### Context Compact Prevention
1. **บันทึกสรุปใน CLAUDE.md นี้เสมอ**
2. **สร้าง commit ก่อน context เต็ม**
3. **สำรองไฟล์สำคัญใน docs/**

### Recent Technical Fixes
- Agent detail click: ใช้ onMouseDown + setTimeout แทน onClick
- Date validation: ใช้ conditional rules based on editingCustomer
- Chart positioning: ย้ายไปบน statistics cards
- Status simplification: 3 statuses instead of 9

## 🎯 Next Possible Tasks
- Project Management implementation
- Reports/Analytics enhancement
- User permission system
- Notification system
- Mobile responsiveness

## 📝 Important Notes
- **การสนทนา: ใช้ภาษาไทยเป็นหลัก** - User ต้องการสนทนาเป็นภาษาไทยเสมอ
- URL อยู่ที่ `/admin/dashboard` เสมอ (SPA routing)
- Agent approval ใช้ status: inactive → active
- Customer statuses: active, inactive, pending เท่านั้น
- Charts ใช้ Recharts library กับ Ant Design
- Modal detail ใช้ Typography.Text component

---
*อัพเดตล่าสุด: หลังแก้ Customer form validation bug*