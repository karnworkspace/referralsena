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

### 6. System Cleanliness & UI Consistency ✅
- **ลบ Debug Code**: ลบ console.log และ debug statements ทั้งหมด
- **ปรับปรุง Customer Status**: แก้ไข model enum จาก 8 สถานะเป็น 3 สถานะ
- **Database Migration**: อัพเดต MySQL ENUM values และ existing data
- **Project Management Actions**: เพิ่มปุ่มแก้ไข/ลบ พร้อม CRUD operations
- **Searchable Project Dropdown**: เปลี่ยน customer form project field เป็น searchable dropdown

### 7. Complete Project Management System ✅
- **Projects API Integration**: สร้าง API endpoints ครบชุด (GET, POST, PUT, DELETE)
- **Database Connection**: เชื่อมต่อกับ MySQL projects table จริง (ไม่ใช่ hardcode)
- **Enhanced Project Form**:
  - เพิ่ม project code field (PROJ001, PROJ002)
  - เพิ่ม project type selection (condo, house, townhome, commercial)
  - เพิ่ม price range fields (min/max) พร้อม number validation
  - เพิ่ม sales team selection dropdown
- **Price Range Features**:
  - InputNumber components รับเฉพาะตัวเลข
  - Thousand separator formatting (3,500,000)
  - Validation: ราคาสูงสุด ≥ ราคาต่ำสุด
  - Required field validation
- **Table Enhancements**:
  - เพิ่ม price range column แสดง 3-line format
  - เพิ่ม sales team column
  - ปรับ status column ใช้ isActive boolean
  - Responsive table พร้อม horizontal scroll
- **Customer Integration**: dropdown โครงการใน customer form โหลดจาก API จริง

### 8. Agent Code Auto-Increment System ✅
- **Backend API**: สร้าง `/api/agents/next-code` endpoint
  - ดึง agent code ล่าสุดจาก database
  - สร้าง next code อัตโนมัติ (AG007 → AG008)
  - Logic: AG + (currentMax + 1) padded 3 digits
- **Frontend Integration**:
  - เพิ่ม agent code field ใน AgentRegister.jsx
  - Auto-fetch และแสดง next code เมื่อ load form
  - Field เป็น read-only พร้อม styling สีฟ้า
  - เพิ่ม refresh button ข้าง label
  - แสดงข้อความอธิบาย "รหัสเอเจนต์ถูกสร้างโดยอัตโนมัติ"
- **Error Handling**: fallback เป็น AG001 หาก API fail
- **UX Improvements**:
  - Loading state ขณะดึงข้อมูล
  - Visual feedback พร้อม icon และ colors

## 🏗️ Project Structure
```
/frontend/src/
├── pages/
│   ├── Dashboard.jsx (main dashboard with charts)
│   ├── AgentManagementNew.jsx (agent CRUD + approval system)
│   ├── CustomerManagement.jsx (customer CRUD with 3 status)
│   ├── ProjectManagement.jsx (complete project CRUD with API)
│   └── ProjectForm.jsx (enhanced form with price range validation)
├── components/charts/
│   ├── StatisticsBarChart.jsx
│   ├── CustomerStatusPieChart.jsx
│   ├── TrendLineChart.jsx
│   └── PerformanceAreaChart.jsx
└── store/ (Redux slices)

/backend/
├── server-mysql.js (complete API with projects endpoints)
└── API endpoints: agents, customers, projects, dashboard
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

### 5. Customer Management Data Display Fixes ✅
- **ปัญหา**: ข้อมูล เอเจนต์, โครงการ, งบประมาณ, ที่อยู่, วันที่ลงทะเบียน ไม่แสดงในตาราง
- **สาเหตุ**: server-mysql.js ไม่ได้ใส่ `as: 'agent'` และ `as: 'project'` ใน include associations
- **การแก้ไข**:
  1. เพิ่ม `as: 'agent'` ใน Agent model includes ทุกที่ใน server-mysql.js
  2. เพิ่ม `as: 'project'` ใน Project model includes ทุกที่ใน server-mysql.js
  3. ใช้ `created_at` field แทน `registrationDate` สำหรับวันที่ลงทะเบียน
  4. ปรับปรุง budget display เป็น 3 บรรทัด (min / - / max)
  5. เพิ่ม null checks ในทุก column rendering
- **ผลลัพธ์**: ข้อมูล agent แสดงเป็น "AG007 - นายอดินันท์" ในคอลัมน์เอเจนต์แล้ว

### Recent Technical Fixes
- **Sequelize Associations**: เพิ่ม `as: 'agent'` และ `as: 'project'` ใน findAndCountAll และ findByPk
- **Budget Display**: ปรับเป็น 3-line format (min / dash / max) พร้อม Thai number formatting
- **Agent Column**: แสดง agentCode + firstName ในรูปแบบ "AG007 - นายอดินันท์"
- **Database Fixes**: เพิ่ม columns registration_date และ address ใน customers table
- **Date Handling**: ใช้ created_at แทน registrationDate สำหรับการแสดงวันที่
- **Projects API**: สร้าง endpoints ใหม่ทั้งหมด และแก้ไข column ordering (createdAt → created_at)
- **Customer Status Model**: อัพเดต enum จาก 8 สถานะเป็น 3 สถานะพร้อม database migration
- **Project Form Validation**: InputNumber พร้อม price range validation และ number formatting
- **Code Cleanup**: ลบ console.log และ debug code ทั้งหมด
- **UI Consistency**: มาตรฐานเดียวกันทุกหน้า (buttons, tables, forms)

## 🎯 Next Possible Tasks
- Reports/Analytics enhancement (charts และ statistics)
- User permission system (role-based access)
- Notification system (real-time alerts)
- Mobile responsiveness (responsive design)
- Activity logging system (audit trail)
- Email integration (notifications)
- File upload functionality (documents/images)
- Advanced search and filtering
- Data export functionality (Excel/PDF)
- Multi-language support

## 📝 Important Notes
- **การสนทนา: ใช้ภาษาไทยเป็นหลัก** - User ต้องการสนทนาเป็นภาษาไทยเสมอ
- **Docker Required**: ใช้ Docker containers เสมอ (ห้าม npm run local)
- **Login Credentials**: admin@test.com / password
- **API Testing**: curl with Bearer token for debugging
- URL อยู่ที่ `/admin/dashboard` เสมอ (SPA routing)
- Agent approval ใช้ status: inactive → active
- Customer statuses: active, inactive, pending เท่านั้น
- Charts ใช้ Recharts library กับ Ant Design
- Modal detail ใช้ Typography.Text component
- Sequelize associations ต้องมี `as` property เสมอ
- **Projects Management**: ใช้ database จริง (ไม่ใช่ hardcode)
- **Price Range Validation**: InputNumber เท่านั้น (ไม่ให้พิมพ์ text)
- **API Integration**: ทุกหน้าเชื่อมต่อ backend API แล้ว

## 🏆 Current System Status
- ✅ **Dashboard**: Charts และ statistics ครบ
- ✅ **Agent Management**: CRUD + approval system พร้อม detail modal
- ✅ **Customer Management**: CRUD + 3 status system + searchable project dropdown
- ✅ **Project Management**: Complete CRUD + price range validation + database integration
- ✅ **Authentication**: Login/logout system
- ✅ **Database**: MySQL พร้อม associations และ proper schema

---
*อัพเดตล่าสุด: Agent Code Auto-Increment System พร้อม UX Enhancements*