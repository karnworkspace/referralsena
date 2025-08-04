# Manual Feature - Agent Referral System

## 📋 ภาพรวมระบบ

ระบบจัดการเอเจนต์และลูกค้า (Agent Referral System) เป็นเว็บแอปพลิเคชันที่พัฒนาด้วย React + Node.js + Ant Design สำหรับการจัดการข้อมูลเอเจนต์ขายและลูกค้าในธุรกิจอสังหาริมทรัพย์

## 🛠️ Tech Stack

### Frontend
- **React 18** - JavaScript Library สำหรับสร้าง UI
- **Vite** - Build Tool และ Development Server
- **Ant Design** - UI Component Library พร้อม Thai Localization
- **Redux Toolkit** - State Management
- **Axios** - HTTP Client สำหรับเรียก API

### Backend
- **Node.js** - Runtime Environment
- **Express.js** - Web Framework
- **JWT** - Authentication
- **CORS** - Cross-Origin Resource Sharing
- **Helmet** - Security Middleware
- **Morgan** - HTTP Request Logger

## 🚀 วิธีการรันระบบ

### 1. เริ่มต้น Backend Server

```bash
cd "/Users/nk-lamy/Desktop/GeminiCLI/agentsena.sena.co.th/referral-system-new/backend"
npm start
```

**เซิร์ฟเวอร์จะรันที่:** `http://localhost:5001`

### 2. เริ่มต้น Frontend Development Server

```bash
cd "/Users/nk-lamy/Desktop/GeminiCLI/agentsena.sena.co.th/referral-system-new/frontend"
npm run dev
```

**เว็บแอปจะรันที่:** `http://localhost:5173`

### 3. การเข้าสู่ระบบ

เปิดเบราว์เซอร์และไปที่ `http://localhost:5173`

**ข้อมูลเข้าสู่ระบบ:**
- **Email:** `admin@test.com`
- **Password:** `123456`

## ✨ ฟีเจอร์หลักของระบบ

### 🔐 ระบบ Authentication
- เข้าสู่ระบบด้วย Email/Password
- JWT Token Authentication
- Auto-redirect เมื่อ session หมดอายุ
- Protected Routes สำหรับหน้าที่ต้องล็อกอิน

---

### 👥 จัดการเอเจนต์ (Agent Management)

#### ฟีเจอร์:
- **แสดงรายการเอเจนต์** - ตารางแสดงข้อมูลเอเจนต์ทั้งหมดพร้อม pagination
- **ค้นหาเอเจนต์** - ค้นหาด้วยชื่อ, รหัสเอเจนต์, หรืออีเมล
- **กรองข้อมูล** - กรองตามสถานะ (ใช้งาน/ไม่ใช้งาน)
- **เพิ่มเอเจนต์ใหม่** - ฟอร์มเพิ่มเอเจนต์พร้อม validation
- **แก้ไขข้อมูลเอเจนต์** - อัพเดทข้อมูลเอเจนต์ที่มีอยู่
- **ลบเอเจนต์** - ลบเอเจนต์พร้อม confirmation dialog

#### ข้อมูลเอเจนต์:
- รหัสเอเจนต์ (Agent Code)
- ชื่อ-นามสกุล
- อีเมล
- เบอร์โทร
- เลขประจำตัวประชาชน
- สถานะ (ใช้งาน/ไม่ใช้งาน)
- วันที่ลงทะเบียน

#### เอเจนต์ตัวอย่างในระบบ:
1. **AG001** - สมชาย ใจดี (somchai@example.com)
2. **AG002** - สุมาลี สวยงาม (sumalee@example.com)
3. **AG003** - วิชาญ เก่งจริง (wichan@example.com)

---

### 👤 จัดการลูกค้า (Customer Management)

#### ฟีเจอร์:
- **แสดงรายการลูกค้า** - ตารางแสดงข้อมูลลูกค้าทั้งหมดพร้อม pagination
- **ค้นหาลูกค้า** - ค้นหาด้วยชื่อ, รหัสลูกค้า, อีเมล, หรือเบอร์โทร
- **กรองข้อมูล** - กรองตามสถานะและเอเจนต์ที่รับผิดชอบ
- **เพิ่มลูกค้าใหม่** - ฟอร์มเพิ่มลูกค้าพร้อม validation
- **แก้ไขข้อมูลลูกค้า** - อัพเดทข้อมูลลูกค้าที่มีอยู่
- **ลบลูกค้า** - ลบลูกค้าพร้อม confirmation dialog
- **มอบหมายเอเจนต์** - เลือกเอเจนต์ที่รับผิดชอบลูกค้า

#### ข้อมูลลูกค้า:
- รหัสลูกค้า (Customer Code)
- ชื่อ-นามสกุล
- อีเมล
- เบอร์โทร
- เลขประจำตัวประชาชน
- ที่อยู่
- เอเจนต์ที่รับผิดชอบ
- สถานะ (ใช้งาน/ไม่ใช้งาน)
- วันที่ลงทะเบียน

#### ลูกค้าตัวอย่างในระบบ:
1. **CU001** - นพดล สุขใจ (เอเจนต์: AG001 - สมชาย ใจดี)
2. **CU002** - สมหญิง ใจดี (เอเจนต์: AG001 - สมชาย ใจดี)
3. **CU003** - วิชาญ มั่งมี (เอเจนต์: AG002 - สุมาลี สวยงาม)
4. **CU004** - นิภา รุ่งเรือง (เอเจนต์: AG002 - สุมาลี สวยงาม)
5. **CU005** - สมศักดิ์ พันธุ์ดี (เอเจนต์: AG003 - วิชาญ เก่งจริง)

---

## 🎨 UI/UX Features

### ภาษาไทย
- Interface ทั้งหมดเป็นภาษาไทย
- Thai date formatting
- Thai localization สำหรับ Ant Design components

### Responsive Design
- รองรับการใช้งานบนหน้าจอขนาดต่างๆ
- Mobile-friendly layout
- Adaptive table และ form layouts

### User Experience
- Loading states สำหรับการโหลดข้อมูล
- Error notifications พร้อมข้อความภาษาไทย
- Success notifications เมื่อดำเนินการสำเร็จ
- Confirmation dialogs สำหรับการลบข้อมูล
- Search และ filter แบบ real-time

---

## 📊 API Endpoints

### Authentication
- `POST /api/auth/login` - เข้าสู่ระบบ
- `GET /api/auth/me` - ดึงข้อมูลผู้ใช้ปัจจุบัน
- `POST /api/auth/logout` - ออกจากระบบ

### Agents Management
- `GET /api/agents` - ดึงรายการเอเจนต์ทั้งหมด
- `GET /api/agents/:id` - ดึงข้อมูลเอเจนต์ตาม ID
- `POST /api/agents` - เพิ่มเอเจนต์ใหม่
- `PUT /api/agents/:id` - แก้ไขข้อมูลเอเจนต์
- `DELETE /api/agents/:id` - ลบเอเจนต์
- `GET /api/agents/list` - ดึงรายชื่อเอเจนต์สำหรับ dropdown

### Customers Management
- `GET /api/customers` - ดึงรายการลูกค้าทั้งหมด
- `GET /api/customers/:id` - ดึงข้อมูลลูกค้าตาม ID
- `POST /api/customers` - เพิ่มลูกค้าใหม่
- `PUT /api/customers/:id` - แก้ไขข้อมูลลูกค้า
- `DELETE /api/customers/:id` - ลบลูกค้า

### System
- `GET /health` - ตรวจสอบสถานะเซิร์ฟเวอร์
- `GET /api/test-db` - ทดสอบการเชื่อมต่อฐานข้อมูล

---

## 🔒 Security Features

- **JWT Authentication** - ใช้ JSON Web Token สำหรับการยืนยันตัวตน
- **CORS Protection** - ป้องกันการเข้าถึงจากโดเมนที่ไม่ได้รับอนุญาต
- **Helmet Security** - เพิ่มความปลอดภัยด้วย HTTP headers
- **Input Validation** - ตรวจสอบข้อมูลที่ป้อนเข้ามา
- **Rate Limiting** - จำกัดจำนวนคำขอต่อหน่วยเวลา (ปิดในโหมด development)

---

## 📱 การใช้งานระบบ

### 1. เข้าสู่ระบบ
1. เปิดเบราว์เซอร์ไปที่ `http://localhost:5173`
2. ใส่ email: `admin@test.com` และ password: `123456`
3. คลิก "เข้าสู่ระบบ"

### 2. จัดการเอเจนต์
1. คลิกเมนู "จัดการเอเจนต์" ในแถบด้านซ้าย
2. ดูรายการเอเจนต์ที่มีอยู่
3. ใช้ช่องค้นหาเพื่อหาเอเจนต์ที่ต้องการ
4. คลิก "เพิ่มเอเจนต์ใหม่" เพื่อเพิ่มเอเจนต์
5. คลิกไอคอน "แก้ไข" หรือ "ลบ" ในแต่ละแถว

### 3. จัดการลูกค้า
1. คลิกเมนู "จัดการลูกค้า" ในแถบด้านซ้าย
2. ดูรายการลูกค้าที่มีอยู่
3. ใช้ตัวกรองเพื่อกรองตามสถานะหรือเอเจนต์
4. คลิก "เพิ่มลูกค้าใหม่" เพื่อเพิ่มลูกค้า
5. เลือกเอเจนต์ที่รับผิดชอบลูกค้าจาก dropdown
6. คลิกไอคอน "แก้ไข" หรือ "ลบ" ในแต่ละแถว

### 4. ออกจากระบบ
- คลิกไอคอน profile ที่มุมขวาบน
- เลือก "ออกจากระบบ" หรือคลิกปุ่ม "ออกจากระบบ" ด้านล่างเมนู

---

## 🐛 การแก้ไขปัญหา

### Backend ไม่สามารถเริ่มได้ (Port ถูกใช้)
```bash
# หา process ที่ใช้ port 5001
lsof -i :5001

# ฆ่า process (แทน PID ด้วยเลขที่ได้)
kill -9 PID
```

### Frontend ไม่สามารถเชื่อมต่อ Backend
1. ตรวจสอบว่า Backend รันอยู่ที่ port 5001
2. ตรวจสอบการตั้งค่า CORS ในไฟล์ `.env`
3. ล้าง browser cache และ localStorage

### ข้อมูลไม่แสดง
1. เปิด Developer Tools (F12)
2. ตรวจสอบ Console เพื่อดู error messages
3. ตรวจสอบ Network tab เพื่อดู API calls

---

## 📁 โครงสร้างโปรเจค

```
referral-system-new/
├── backend/                 # Node.js Backend
│   ├── .env                # Environment variables
│   ├── server.js           # Main server file
│   ├── src/
│   │   └── config/         # Configuration files
│   └── package.json        # Backend dependencies
├── frontend/               # React Frontend
│   ├── src/
│   │   ├── components/     # Reusable components
│   │   ├── pages/          # Page components
│   │   ├── store/          # Redux store และ slices
│   │   ├── services/       # API services
│   │   └── App.jsx         # Main App component
│   ├── package.json        # Frontend dependencies
│   └── vite.config.js      # Vite configuration
├── database-schema.sql     # Database schema
└── manualfeature.md        # คู่มือนี้
```

---

## 🔄 การพัฒนาต่อ

### ฟีเจอร์ที่สามารถเพิ่มได้:
1. **Projects Management** - จัดการโครงการอสังหาริมทรัพย์
2. **Sales Tracking** - ติดตามยอดขายและคอมมิชชั่น
3. **Reports Dashboard** - รายงานสถิติและกราฟ
4. **File Upload** - อัพโหลดไฟล์เอกสาร
5. **Real Database** - เชื่อมต่อกับ MySQL หรือ PostgreSQL
6. **Email Notifications** - ส่งอีเมลแจ้งเตือน
7. **Export to Excel** - ส่งออกข้อมูลเป็นไฟล์ Excel

### การเชื่อมต่อฐานข้อมูลจริง:
ใช้ไฟล์ `database-schema.sql` เพื่อสร้างตารางในฐานข้อมูล MySQL และแทนที่ mock data ด้วย Sequelize ORM

---

*📝 เอกสารนี้สร้างขึ้นเมื่อ: **4 สิงหาคม 2025***