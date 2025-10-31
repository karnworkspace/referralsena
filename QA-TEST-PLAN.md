# 📋 SENA Agent - QA Test Plan

**โครงการ:** SENA Agent Referral System
**เวอร์ชัน:** 2.0
**วันที่จัดทำ:** 2025-10-22
**ผู้จัดทำ:** QA Team

---

## 📌 สารบัญ

1. [ภาพรวมระบบ](#-ภาพรวมระบบ)
2. [User Roles และสิทธิ์การใช้งาน](#-user-roles-และสิทธิการใชงาน)
3. [Test Environment](#-test-environment)
4. [Test Strategy](#-test-strategy)
5. [Test Cases - Authentication & Authorization](#-test-cases---authentication--authorization)
6. [Test Cases - Admin Role](#-test-cases---admin-role)
7. [Test Cases - Agent Role](#-test-cases---agent-role)
8. [Test Cases - Cross-Role Testing](#-test-cases---cross-role-testing)
9. [Test Cases - Integration Testing](#-test-cases---integration-testing)
10. [Test Cases - UI/UX Testing](#-test-cases---uiux-testing)
11. [Test Cases - Security Testing](#-test-cases---security-testing)
12. [Test Cases - Performance Testing](#-test-cases---performance-testing)
13. [Bug Severity Classification](#-bug-severity-classification)
14. [Test Execution Tracking](#-test-execution-tracking)

---

## 🎯 ภาพรวมระบบ

### เกี่ยวกับระบบ
SENA Agent Referral System เป็นระบบจัดการเอเจนต์และลูกค้าสำหรับธุรกิจอสังหาริมทรัพย์ โดยมีฟีเจอร์หลัก:
- จัดการข้อมูลเอเจนต์ (Agent Management)
- จัดการข้อมูลลูกค้า (Customer Management)
- จัดการข้อมูลโครงการ (Project Management)
- Dashboard และ Analytics
- ระบบอนุมัติเอเจนต์ใหม่

### Tech Stack
- **Frontend:** React + Ant Design + Redux Toolkit
- **Backend:** Node.js + Express + Sequelize ORM
- **Database:** MySQL 8.0
- **Authentication:** JWT (JSON Web Token)
- **Deployment:** Docker + Docker Compose

---

## 👥 User Roles และสิทธิ์การใช้งาน

### 1. **Admin Role** (ผู้ดูแลระบบ)

#### สิทธิ์การเข้าถึง:
- ✅ **Dashboard** - เข้าถึงได้ (Full Access)
  - ดูสถิติรวมทั้งหมด (agents, customers, projects)
  - ดู Charts และ Analytics
  - ดู Recent Activities

- ✅ **Agent Management** - เข้าถึงได้ (Full CRUD)
  - ดูรายการเอเจนต์ทั้งหมด
  - เพิ่มเอเจนต์ใหม่ (รหัสเอเจนต์ auto-increment: AG001, AG002,...)
  - แก้ไขข้อมูลเอเจนต์
  - ลบเอเจนต์
  - อนุมัติ/ปฏิเสธเอเจนต์ที่รออนุมัติ (status: inactive → active)
  - ดูรายละเอียดเอเจนต์แบบละเอียด (คลิกรหัสเอเจนต์)
  - Filter by status (all, active, inactive, suspended)
  - Search agents

- ✅ **Customer Management** - เข้าถึงได้ (Full CRUD)
  - ดูรายการลูกค้าทั้งหมด (ของทุก agent)
  - เพิ่มลูกค้าใหม่
  - แก้ไขข้อมูลลูกค้า
  - ลบลูกค้า
  - ดูรายละเอียดลูกค้า
  - Filter by status (active, inactive, pending)
  - Search customers
  - เลือกโครงการที่สนใจ (Searchable Dropdown)

- ✅ **Project Management** - เข้าถึงได้ (Full CRUD)
  - ดูรายการโครงการทั้งหมด
  - เพิ่มโครงการใหม่ (รหัสโครงการ: PROJ001, PROJ002,...)
  - แก้ไขข้อมูลโครงการ
  - ลบโครงการ
  - จัดการประเภทโครงการ (condo, house, townhome, commercial)
  - กำหนด Price Range (min-max) พร้อม validation
  - กำหนด Sales Team

#### Dashboard Features:
- Statistics Cards: Total Agents, Pending Agents, Active Agents, Total Customers, New Customers
- 4 Charts:
  1. Statistics Bar Chart (Agent vs Customer comparison)
  2. Customer Status Pie Chart (status distribution)
  3. Trend Line Chart (monthly trends)
  4. Performance Area Chart (weekly performance)
- Recent Activities List

---

### 2. **Agent Role** (เอเจนต์)

#### สิทธิ์การเข้าถึง:
- ✅ **Agent Dashboard** - เข้าถึงได้ (Read Only)
  - ดูโปรไฟล์ส่วนตัว
  - ดูรายการลูกค้าของตัวเอง (filtered by agentId)
  - ดูสถิติส่วนตัว
  - แก้ไขโปรไฟล์ (phone number)

- ❌ **Agent Management** - เข้าถึงไม่ได้
- ❌ **Customer Management** - เข้าถึงไม่ได้ (เห็นเฉพาะใน Agent Dashboard)
- ❌ **Project Management** - เข้าถึงไม่ได้
- ❌ **Full Dashboard** - เข้าถึงไม่ได้

#### Limitations:
- ไม่สามารถ CRUD customers ผ่าน API (backend protected by `authorize('admin', 'manager')`)
- แสดงเฉพาะลูกค้าของตัวเอง (ไม่เห็นลูกค้าของ agent อื่น)
- Dashboard เป็น read-only

---

### 3. **Manager Role** (ผู้จัดการ)

#### สิทธิ์การเข้าถึง:
- สิทธิ์เหมือน **Admin** ทุกประการ
- ใช้สำหรับ role-based access ใน backend middleware

---

## 🔧 Test Environment

### Local Development
- **Frontend URL:** http://localhost:3000
- **Backend API URL:** http://localhost:4000/api
- **phpMyAdmin URL:** http://localhost:8080
- **Database:** MySQL 8.0 (Port 3306)

### Production Server
- **Server IP:** 172.22.22.11
- **Frontend URL:** http://172.22.22.11:3000
- **Backend API URL:** http://172.22.22.11:4000/api
- **phpMyAdmin URL:** http://172.22.22.11:8080
- **Database:** MySQL 8.0 (Port 3306)

### Test Accounts
```
Admin Account:
Email: admin@test.com
Password: password
Role: admin

Agent Account (ต้องสร้างใหม่หรือใช้ที่มีอยู่):
Email: [agent email from database]
Password: [agent idCard - same as registration]
Role: agent
```

### Database Access
```
MySQL Host: localhost (or 172.22.22.11 for production)
Database: sena_referral
Username: sena_user
Password: sena_password
Root Password: rootpassword
```

---

## 📊 Test Strategy

### Testing Levels
1. **Unit Testing** - ทดสอบ components และ functions แยกส่วน
2. **Integration Testing** - ทดสอบการทำงานร่วมกันระหว่าง frontend-backend-database
3. **System Testing** - ทดสอบระบบโดยรวมตาม user scenarios
4. **User Acceptance Testing (UAT)** - ทดสอบโดย end users จริง

### Testing Types
- **Functional Testing** - ทดสอบฟังก์ชันการทำงานตาม requirements
- **Security Testing** - ทดสอบการ authentication, authorization, CORS
- **UI/UX Testing** - ทดสอบ responsive design, user interactions
- **Performance Testing** - ทดสอบ load time, response time
- **Compatibility Testing** - ทดสอบบน browsers ต่างๆ (Chrome, Firefox, Safari, Edge)
- **Database Testing** - ทดสอบ CRUD operations, data integrity, charset encoding

### Test Execution Order
```
1. Authentication & Authorization Tests (ต้องผ่านก่อน)
2. Admin Role Tests (Dashboard, Agents, Customers, Projects)
3. Agent Role Tests (Agent Dashboard)
4. Cross-Role Tests (permission boundaries)
5. Integration Tests (end-to-end workflows)
6. UI/UX Tests
7. Security Tests
8. Performance Tests
```

---

## 🔐 Test Cases - Authentication & Authorization

### TC-AUTH-001: Login with Admin Account
**Priority:** Critical
**Role:** Admin
**Precondition:** ต้องมี admin account ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิดเบราว์เซอร์ไปที่ `/login` | แสดงหน้า Login |
| 2 | กรอก Email: `admin@test.com` | Input field รับค่าได้ |
| 3 | กรอก Password: `password` | Input field รับค่าได้ (แสดงเป็น ••••) |
| 4 | คลิกปุ่ม "เข้าสู่ระบบ" | Redirect ไปที่ `/admin/dashboard` |
| 5 | ตรวจสอบ token ใน localStorage | มี `token` และ `user` object |
| 6 | ตรวจสอบ user role | `user.role === 'admin'` |

**Test Data:**
```json
{
  "email": "admin@test.com",
  "password": "password"
}
```

**Expected Response (from API):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "email": "admin@test.com",
      "role": "admin",
      "isActive": true
    },
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "refreshToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
  }
}
```

---

### TC-AUTH-002: Login with Agent Account
**Priority:** Critical
**Role:** Agent
**Precondition:** ต้องมี agent account (status: active) ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิดเบราว์เซอร์ไปที่ `/login` | แสดงหน้า Login |
| 2 | กรอก Email ของ agent | Input field รับค่าได้ |
| 3 | กรอก Password (idCard) | Input field รับค่าได้ |
| 4 | คลิกปุ่ม "เข้าสู่ระบบ" | Redirect ไปที่ `/agent/dashboard` |
| 5 | ตรวจสอบ user role | `user.role === 'agent'` |
| 6 | ตรวจสอบ agent object | `user.agent` object populated |

---

### TC-AUTH-003: Login with Invalid Credentials
**Priority:** High
**Role:** All

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิดหน้า `/login` | แสดงหน้า Login |
| 2 | กรอก Email: `wrong@test.com` | - |
| 3 | กรอก Password: `wrongpassword` | - |
| 4 | คลิกปุ่ม "เข้าสู่ระบบ" | แสดง error message "อีเมลหรือรหัสผ่านไม่ถูกต้อง" |
| 5 | ตรวจสอบ localStorage | ไม่มี token และ user |

---

### TC-AUTH-004: Login with Inactive Agent
**Priority:** High
**Role:** Agent
**Precondition:** มี agent account ที่ status = 'inactive'

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิดหน้า `/login` | แสดงหน้า Login |
| 2 | กรอก Email ของ agent (status: inactive) | - |
| 3 | กรอก Password | - |
| 4 | คลิกปุ่ม "เข้าสู่ระบบ" | แสดง error "บัญชีผู้ใช้ถูกระงับ" หรือ "รอการอนุมัติ" |

---

### TC-AUTH-005: Logout
**Priority:** High
**Role:** All
**Precondition:** User logged in

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกที่ avatar ขวาบน | แสดง dropdown menu |
| 2 | คลิก "ออกจากระบบ" | - |
| 3 | ตรวจสอบ redirect | Redirect ไปที่ `/login` |
| 4 | ตรวจสอบ localStorage | token และ user ถูกลบ |
| 5 | ทดสอบเข้า `/admin/dashboard` โดยตรง | Redirect กลับไป `/login` |

---

### TC-AUTH-006: Access Protected Route Without Token
**Priority:** Critical
**Role:** All

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิด browser (incognito mode) | - |
| 2 | ไปที่ `/admin/dashboard` โดยตรง | Redirect ไปที่ `/login` |
| 3 | ไปที่ `/agent/dashboard` โดยตรง | Redirect ไปที่ `/login` |

---

### TC-AUTH-007: Token Expiration Handling
**Priority:** High
**Role:** All
**Precondition:** User logged in

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login เข้าระบบ | Success |
| 2 | เปลี่ยน token ใน localStorage เป็น invalid token | - |
| 3 | Refresh หน้า หรือ call API | Auto redirect ไปที่ `/login` |
| 4 | แสดง error message | "Token หมดอายุแล้ว" หรือ "กรุณาเข้าสู่ระบบอีกครั้ง" |

---

### TC-AUTH-008: JWT Token Security
**Priority:** Critical
**Role:** All

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login และดึง token จาก localStorage | - |
| 2 | Decode JWT token (ใช้ jwt.io) | ต้องมี payload: `{ id, iat, exp }` |
| 3 | ตรวจสอบ algorithm | HMAC-SHA256 (HS256) |
| 4 | ตรวจสอบ expiration | exp = iat + 7 days (604800 seconds) |

---

### TC-AUTH-009: Agent Registration
**Priority:** High
**Role:** Public

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่ `/register-agent` | แสดงหน้า Agent Registration Form |
| 2 | ระบบแสดง Agent Code อัตโนมัติ | เช่น AG007 (auto-increment) |
| 3 | กรอกข้อมูล: firstName, lastName, email, phone, idCard, address, registrationDate | All fields required |
| 4 | คลิกปุ่ม "ลงทะเบียน" | - |
| 5 | ตรวจสอบ response | Success message "ลงทะเบียนสำเร็จ กรุณารอการอนุมัติ" |
| 6 | ตรวจสอบ database | Agent ถูกสร้างด้วย status: 'inactive' |
| 7 | ตรวจสอบ User | User ถูกสร้างด้วย role: 'agent', password: idCard (hashed) |

**Validation Tests:**
- Email format validation
- ID Card 13 digits
- Phone number format
- Required fields validation

---

### TC-AUTH-010: CORS Policy Testing
**Priority:** Critical
**Role:** System

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เปิด browser console (F12) | - |
| 2 | Login เข้าระบบ | - |
| 3 | ตรวจสอบ Network tab → Headers | `Access-Control-Allow-Origin` มี frontend URL |
| 4 | ตรวจสอบ console | ไม่มี CORS error |

**Allowed Origins:**
- `http://localhost:3000`
- `http://localhost:5173`
- `http://172.22.22.11:3000`
- `http://172.22.22.11:5173`

---

## 👨‍💼 Test Cases - Admin Role

### Dashboard Module

#### TC-ADMIN-DASH-001: View Dashboard Statistics
**Priority:** High
**Role:** Admin
**Precondition:** Logged in as admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login และไปที่ `/admin/dashboard` | แสดง Dashboard |
| 2 | ตรวจสอบ Statistics Cards | แสดง 6 cards:<br>- Total Agents<br>- Pending Agents<br>- Active Agents<br>- Total Customers<br>- New Customers<br>- Pending Customers |
| 3 | ตรวจสอบตัวเลข | ตัวเลขตรงกับ database (เปิด phpMyAdmin เช็ค) |
| 4 | ตรวจสอบ icon และสี | แต่ละ card มี icon และสีที่เหมาะสม |

---

#### TC-ADMIN-DASH-002: View Dashboard Charts
**Priority:** Medium
**Role:** Admin
**Precondition:** Logged in as admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Scroll ลงมาดู Charts section | แสดง 4 charts |
| 2 | ตรวจสอบ Statistics Bar Chart | แสดง Agent vs Customer comparison |
| 3 | ตรวจสอบ Customer Status Pie Chart | แสดง status distribution (active, inactive, pending) |
| 4 | ตรวจสอบ Trend Line Chart | แสดง monthly trends |
| 5 | ตรวจสอบ Performance Area Chart | แสดง weekly performance |
| 6 | Hover บน chart | แสดง tooltip พร้อมข้อมูล |

---

#### TC-ADMIN-DASH-003: View Recent Activities
**Priority:** Low
**Role:** Admin
**Precondition:** Logged in as admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Scroll ลงมาดู Recent Activities | แสดง list ของ activities |
| 2 | ตรวจสอบ content | แสดงรายการ activities ล่าสุด (ถ้ามี) |
| 3 | ตรวจสอบ timestamp | แสดงเวลาที่ถูกต้อง |

---

### Agent Management Module

#### TC-ADMIN-AGENT-001: View All Agents
**Priority:** High
**Role:** Admin
**Precondition:** Logged in as admin, มี agents ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกเมนู "Agent Management" | แสดงหน้า Agent Management |
| 2 | ตรวจสอบ table | แสดง list ของ agents ทั้งหมด |
| 3 | ตรวจสอบ columns | มี columns:<br>- รหัสเอเจนต์ (Agent Code)<br>- ชื่อ-นามสกุล<br>- อีเมล<br>- เบอร์โทร<br>- เลขบัตรประชาชน<br>- วันที่ลงทะเบียน<br>- สถานะ<br>- การดำเนินการ |
| 4 | ตรวจสอบจำนวน records | ตรงกับ database |

---

#### TC-ADMIN-AGENT-002: Filter Agents by Status
**Priority:** Medium
**Role:** Admin
**Precondition:** มี agents หลายสถานะใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่หน้า Agent Management | แสดง agents ทั้งหมด (default: all) |
| 2 | คลิกปุ่ม "Active" ใน filter | แสดงเฉพาะ agents ที่ status = active |
| 3 | คลิกปุ่ม "Inactive" | แสดงเฉพาะ agents ที่ status = inactive |
| 4 | คลิกปุ่ม "Suspended" | แสดงเฉพาะ agents ที่ status = suspended |
| 5 | คลิกปุ่ม "All" | แสดงทั้งหมดอีกครั้ง |

---

#### TC-ADMIN-AGENT-003: Search Agents
**Priority:** Medium
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่หน้า Agent Management | แสดง search box |
| 2 | พิมพ์ชื่อ agent ใน search box | - |
| 3 | กด Enter หรือคลิก search icon | แสดงเฉพาะ agents ที่ตรงกับ keyword |
| 4 | ทดสอบ search ด้วย agent code | แสดงผลลัพธ์ที่ตรงกับ code |
| 5 | ทดสอบ search ด้วย email | แสดงผลลัพธ์ที่ตรงกับ email |
| 6 | Clear search | แสดงทั้งหมดอีกครั้ง |

---

#### TC-ADMIN-AGENT-004: View Agent Details
**Priority:** Medium
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่หน้า Agent Management | - |
| 2 | คลิกที่ "รหัสเอเจนต์" (Agent Code) | - |
| 3 | ตรวจสอบ modal | เปิด Detail Modal |
| 4 | ตรวจสอบข้อมูลใน modal | แสดงข้อมูลครบ:<br>- รหัสเอเจนต์<br>- ชื่อ-นามสกุล<br>- อีเมล<br>- เบอร์โทร<br>- เลขบัตรประชาชน<br>- ที่อยู่<br>- วันที่ลงทะเบียน<br>- สถานะ |
| 5 | คลิกปุ่ม "ปิด" | Modal ปิด |

---

#### TC-ADMIN-AGENT-005: Add New Agent
**Priority:** Critical
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "เพิ่มเอเจนต์" | เปิด Add Agent Modal |
| 2 | ตรวจสอบ Agent Code field | แสดง next agent code อัตโนมัติ (เช่น AG008)<br>Field เป็น read-only (สีฟ้า) |
| 3 | คลิกปุ่ม refresh ข้าง label | Reload agent code ใหม่ |
| 4 | กรอกข้อมูล:<br>- firstName: "ทดสอบ"<br>- lastName: "QA"<br>- email: "test.qa@test.com"<br>- phone: "0812345678"<br>- idCard: "1234567890123"<br>- address: "Bangkok"<br>- registrationDate: (วันนี้)<br>- status: "active" | - |
| 5 | คลิกปุ่ม "บันทึก" | - |
| 6 | ตรวจสอบ response | แสดง success notification "เพิ่มเอเจนต์สำเร็จ" |
| 7 | ตรวจสอบ table | มี agent ใหม่ใน list |
| 8 | ตรวจสอบ database | Agent ถูกสร้างใน `agents` table<br>User ถูกสร้างใน `users` table ด้วย role: 'agent' |

**Expected Database Records:**
```sql
-- agents table
INSERT INTO agents (agent_code, first_name, last_name, phone, id_card, address, registration_date, status)
VALUES ('AG008', 'ทดสอบ', 'QA', '0812345678', '1234567890123', 'Bangkok', '2025-10-22', 'active');

-- users table (automatically created)
INSERT INTO users (email, password, role, is_active)
VALUES ('test.qa@test.com', '$2b$10$...hashed...', 'agent', true);
```

---

#### TC-ADMIN-AGENT-006: Add Agent - Validation Tests
**Priority:** High
**Role:** Admin

| Test Case | Field | Input | Expected Result |
|-----------|-------|-------|-----------------|
| 6a | firstName | (empty) | แสดง error "กรุณากรอกชื่อ" |
| 6b | lastName | (empty) | แสดง error "กรุณากรอกนามสกุล" |
| 6c | email | "notanemail" | แสดง error "รูปแบบอีเมลไม่ถูกต้อง" |
| 6d | email | "admin@test.com" (duplicate) | แสดง error "อีเมลนี้ถูกใช้งานแล้ว" |
| 6e | phone | "123" | แสดง error "เบอร์โทรไม่ถูกต้อง" |
| 6f | idCard | "123" | แสดง error "เลขบัตรประชาชนต้องเป็น 13 หลัก" |
| 6g | idCard | "1234567890123" (duplicate) | แสดง error "เลขบัตรประชาชนนี้ถูกใช้งานแล้ว" |
| 6h | registrationDate | (empty) | แสดง error "กรุณาเลือกวันที่ลงทะเบียน" |

---

#### TC-ADMIN-AGENT-007: Edit Agent
**Priority:** High
**Role:** Admin
**Precondition:** มี agent ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "แก้ไข" (EditOutlined) ของ agent | เปิด Edit Agent Modal |
| 2 | ตรวจสอบ form | ข้อมูลเดิมถูก populate ใน form |
| 3 | ตรวจสอบ Agent Code field | เป็น read-only (ห้ามแก้ไข) |
| 4 | แก้ไข phone: "0898765432" | - |
| 5 | แก้ไข status: "suspended" | - |
| 6 | คลิกปุ่ม "บันทึก" | - |
| 7 | ตรวจสอบ response | แสดง success notification "อัพเดทข้อมูลเอเจนต์สำเร็จ" |
| 8 | ตรวจสอบ table | ข้อมูลถูกอัพเดท |
| 9 | ตรวจสอบ database | ข้อมูลใน `agents` table ถูกอัพเดท |

---

#### TC-ADMIN-AGENT-008: Delete Agent
**Priority:** Critical
**Role:** Admin
**Precondition:** มี agent ที่ไม่มีลูกค้า (เพื่อหลีกเลี่ยง foreign key constraint)

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "ลบ" (DeleteOutlined) ของ agent | แสดง Popconfirm "คุณแน่ใจหรือไม่ที่จะลบเอเจนต์นี้?" |
| 2 | คลิกปุ่ม "ยกเลิก" | ไม่มีอะไรเกิดขึ้น |
| 3 | คลิกปุ่ม "ลบ" อีกครั้ง | แสดง Popconfirm |
| 4 | คลิกปุ่ม "ตรวจสอบ" | - |
| 5 | ตรวจสอบ response | แสดง success notification "ลบเอเจนต์สำเร็จ" |
| 6 | ตรวจสอบ table | Agent หายไปจาก list |
| 7 | ตรวจสอบ database | Agent ถูกลบจาก `agents` table<br>User ถูกลบจาก `users` table (ON DELETE CASCADE) |

---

#### TC-ADMIN-AGENT-009: Delete Agent with Customers
**Priority:** High
**Role:** Admin
**Precondition:** มี agent ที่มีลูกค้า

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "ลบ" ของ agent ที่มีลูกค้า | แสดง Popconfirm |
| 2 | คลิกปุ่ม "ตรวจสอบ" | - |
| 3 | ตรวจสอบ response | แสดง error "ไม่สามารถลบเอเจนต์ได้ เนื่องจากมีลูกค้าที่เกี่ยวข้อง" หรือ foreign key constraint error |

---

#### TC-ADMIN-AGENT-010: Approve Pending Agent
**Priority:** Critical
**Role:** Admin
**Precondition:** มี agent ที่ status = 'inactive' (pending approval)

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่หน้า Agent Management | - |
| 2 | Filter by "Inactive" | แสดงเฉพาะ agents ที่รออนุมัติ |
| 3 | ในคอลัมน์ "การดำเนินการ" มีปุ่ม approve (CheckOutlined) และ reject (CloseOutlined) | - |
| 4 | คลิกปุ่ม approve (เครื่องหมายถูก สีเขียว) | แสดง Popconfirm "คุณต้องการอนุมัติเอเจนต์นี้หรือไม่?" |
| 5 | คลิกปุ่ม "ตรวจสอบ" | - |
| 6 | ตรวจสอบ response | แสดง success notification "อนุมัติเอเจนต์สำเร็จ" |
| 7 | ตรวจสอบ table | Agent status เปลี่ยนเป็น "active" |
| 8 | ตรวจสอบ database | `agents.status` = 'active'<br>`users.is_active` = true |
| 9 | ทดสอบ login ด้วย agent account | Login สำเร็จ |

---

#### TC-ADMIN-AGENT-011: Reject Pending Agent
**Priority:** High
**Role:** Admin
**Precondition:** มี agent ที่ status = 'inactive' (pending approval)

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Filter by "Inactive" | แสดงเฉพาะ agents ที่รออนุมัติ |
| 2 | คลิกปุ่ม reject (เครื่องหมายกากบาท สีแดง) | แสดง Popconfirm "คุณต้องการปฏิเสธเอเจนต์นี้หรือไม่?" |
| 3 | คลิกปุ่ม "ตรวจสอบ" | - |
| 4 | ตรวจสอบ response | แสดง success notification หรือ agent ถูกลบ |
| 5 | ตรวจสอบ table | Agent หายไปจาก list หรือ status เปลี่ยน |
| 6 | ตรวจสอบ database | Agent ถูกลบ หรือ status เปลี่ยนเป็น 'suspended' |

---

### Customer Management Module

#### TC-ADMIN-CUST-001: View All Customers
**Priority:** High
**Role:** Admin
**Precondition:** Logged in as admin, มี customers ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกเมนู "Customer Management" | แสดงหน้า Customer Management |
| 2 | ตรวจสอบ table | แสดง list ของ customers ทั้งหมด (ของทุก agent) |
| 3 | ตรวจสอบ columns | มี columns:<br>- รหัสลูกค้า<br>- ชื่อ-นามสกุล<br>- เบอร์โทร<br>- อีเมล<br>- เอเจนต์<br>- โครงการที่สนใจ<br>- งบประมาณ<br>- ที่อยู่<br>- วันที่ลงทะเบียน<br>- สถานะ<br>- การดำเนินการ |
| 4 | ตรวจสอบ column "เอเจนต์" | แสดงเป็น "AG007 - นายอดินันท์" (agentCode + firstName) |
| 5 | ตรวจสอบ column "งบประมาณ" | แสดงเป็น 3 บรรทัด:<br>฿3,500,000 (min)<br>-<br>฿8,500,000 (max) |

---

#### TC-ADMIN-CUST-002: Filter Customers by Status
**Priority:** Medium
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่หน้า Customer Management | แสดงทั้งหมด (default: all) |
| 2 | เลือก status "ใช้งาน" (active) ใน dropdown | แสดงเฉพาะ customers ที่ status = active |
| 3 | เลือก status "ไม่ใช้งาน" (inactive) | แสดงเฉพาะ customers ที่ status = inactive |
| 4 | เลือก status "รออนุมัติ" (pending) | แสดงเฉพาะ customers ที่ status = pending |
| 5 | เลือก "ทั้งหมด" | แสดงทั้งหมดอีกครั้ง |

**Note:** ระบบมี 3 สถานะเท่านั้น (active, inactive, pending) ไม่ใช่ 8-9 สถานะแบบเดิม

---

#### TC-ADMIN-CUST-003: Search Customers
**Priority:** Medium
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | พิมพ์ชื่อลูกค้าใน search box | - |
| 2 | กด Enter หรือคลิก search icon | แสดงเฉพาะลูกค้าที่ตรงกับ keyword |
| 3 | ทดสอบ search ด้วย customer code | แสดงผลลัพธ์ที่ตรง |
| 4 | ทดสอบ search ด้วย phone number | แสดงผลลัพธ์ที่ตรง |
| 5 | Clear search | แสดงทั้งหมดอีกครั้ง |

---

#### TC-ADMIN-CUST-004: View Customer Details
**Priority:** Medium
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกที่ "รหัสลูกค้า" (Customer Code) | เปิด View Customer Modal |
| 2 | ตรวจสอบข้อมูล | แสดงข้อมูลครบทุก field |
| 3 | ตรวจสอบ formatting | งบประมาณแสดง Thai number format<br>วันที่แสดง Thai date format |
| 4 | คลิกปุ่ม "ปิด" | Modal ปิด |

---

#### TC-ADMIN-CUST-005: Add New Customer
**Priority:** Critical
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "เพิ่มลูกค้า" | เปิด Add Customer Modal |
| 2 | กรอกข้อมูล:<br>- firstName: "ทดสอบ"<br>- lastName: "ลูกค้า"<br>- phone: "0887654321"<br>- email: "customer@test.com"<br>- idCard: "9876543210987"<br>- agentId: (เลือก agent จาก dropdown)<br>- projectId: (เลือก project จาก searchable dropdown)<br>- budgetMin: 3500000<br>- budgetMax: 5000000<br>- address: "Bangkok"<br>- status: "active" | - |
| 3 | ตรวจสอบ Project dropdown | เป็น searchable dropdown<br>พิมพ์ชื่อโครงการแล้วค้นหาได้ |
| 4 | คลิกปุ่ม "บันทึก" | - |
| 5 | ตรวจสอบ response | แสดง success notification "เพิ่มลูกค้าสำเร็จ" |
| 6 | ตรวจสอบ table | มีลูกค้าใหม่ใน list |
| 7 | ตรวจสอบ database | Customer ถูกสร้างใน `customers` table |
| 8 | ตรวจสอบ column "เอเจนต์" | แสดงข้อมูล agent ถูกต้อง |
| 9 | ตรวจสอบ column "โครงการ" | แสดงชื่อโครงการถูกต้อง |

---

#### TC-ADMIN-CUST-006: Add Customer - Validation Tests
**Priority:** High
**Role:** Admin

| Test Case | Field | Input | Expected Result |
|-----------|-------|-------|-----------------|
| 6a | firstName | (empty) | แสดง error "กรุณากรอกชื่อ" |
| 6b | lastName | (empty) | แสดง error "กรุณากรอกนามสกุล" |
| 6c | phone | "123" | แสดง error "เบอร์โทรไม่ถูกต้อง" |
| 6d | email | "notanemail" | แสดง error "รูปแบบอีเมลไม่ถูกต้อง" |
| 6e | budgetMin | (empty) | Allow (not required in edit mode) |
| 6f | budgetMax < budgetMin | min: 5000000, max: 3000000 | แสดง error "งบประมาณสูงสุดต้องมากกว่าหรือเท่ากับงบประมาณต่ำสุด" |
| 6g | agentId | (empty) | แสดง error "กรุณาเลือกเอเจนต์" |

---

#### TC-ADMIN-CUST-007: Edit Customer
**Priority:** High
**Role:** Admin
**Precondition:** มี customer ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "แก้ไข" (EditOutlined) ของ customer | เปิด Edit Customer Modal |
| 2 | ตรวจสอบ form | ข้อมูลเดิมถูก populate ใน form |
| 3 | ตรวจสอบ registrationDate field | **แก้ไขได้** (ไม่ใช่ required ใน edit mode) |
| 4 | แก้ไข phone: "0811111111" | - |
| 5 | แก้ไข status: "inactive" | - |
| 6 | คลิกปุ่ม "บันทึก" | - |
| 7 | ตรวจสอบ response | แสดง success notification "อัพเดทข้อมูลลูกค้าสำเร็จ" |
| 8 | ตรวจสอบ table | ข้อมูลถูกอัพเดท |
| 9 | ตรวจสอบ database | ข้อมูลถูกอัพเดทใน `customers` table |

**Bug Fix Note:** registrationDate field ใน edit mode ไม่ควรเป็น required และต้องใช้ format YYYY-MM-DD สำหรับ input type="date"

---

#### TC-ADMIN-CUST-008: Delete Customer
**Priority:** Critical
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "ลบ" (DeleteOutlined) ของ customer | แสดง Popconfirm "คุณแน่ใจหรือไม่ที่จะลบลูกค้านี้?" |
| 2 | คลิกปุ่ม "ยกเลิก" | ไม่มีอะไรเกิดขึ้น |
| 3 | คลิกปุ่ม "ลบ" อีกครั้ง | แสดง Popconfirm |
| 4 | คลิกปุ่ม "ตรวจสอบ" | - |
| 5 | ตรวจสอบ response | แสดง success notification "ลบลูกค้าสำเร็จ" |
| 6 | ตรวจสอบ table | Customer หายไปจาก list |
| 7 | ตรวจสอบ database | Customer ถูกลบจาก `customers` table |

---

#### TC-ADMIN-CUST-009: Customer Status Tag Colors
**Priority:** Low
**Role:** Admin

| Status | Expected Color | Expected Text |
|--------|----------------|---------------|
| active | Green | ใช้งาน |
| inactive | Red | ไม่ใช้งาน |
| pending | Orange | รออนุมัติ |

---

### Project Management Module

#### TC-ADMIN-PROJ-001: View All Projects
**Priority:** High
**Role:** Admin
**Precondition:** Logged in as admin, มี projects ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกเมนู "Project Management" | แสดงหน้า Project Management |
| 2 | ตรวจสอบ table | แสดง list ของ projects ทั้งหมด |
| 3 | ตรวจสอบ columns | มี columns:<br>- ชื่อโครงการ<br>- ตำแหน่งที่ตั้ง<br>- ราคา (บาท)<br>- ทีมขาย<br>- สถานะ<br>- การดำเนินการ |
| 4 | ตรวจสอบ column "ราคา (บาท)" | แสดงเป็น 3 บรรทัด:<br>฿3,500,000<br>-<br>฿8,500,000 |
| 5 | ตรวจสอบ Thai number formatting | มี comma separator (3,500,000) |

---

#### TC-ADMIN-PROJ-002: Add New Project
**Priority:** Critical
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "เพิ่มโครงการ" | เปลี่ยนไปหน้า Project Form |
| 2 | กรอกข้อมูล:<br>- projectCode: "PROJ999"<br>- projectName: "The Reserve Test"<br>- projectType: "condo"<br>- location: "Bangkok"<br>- priceRangeMin: 3500000<br>- priceRangeMax: 8500000<br>- salesTeam: "Team Test"<br>- isActive: true | - |
| 3 | ตรวจสอบ Price Range fields | เป็น InputNumber (รับเฉพาะตัวเลข)<br>แสดง thousand separator |
| 4 | ทดสอบพิมพ์ text ใน price field | ไม่สามารถพิมพ์ text ได้ |
| 5 | คลิกปุ่ม "บันทึก" | - |
| 6 | ตรวจสอบ response | แสดง success message "เพิ่มโครงการสำเร็จ" |
| 7 | ตรวจสอบ redirect | กลับไปหน้า Project List |
| 8 | ตรวจสอบ table | มีโครงการใหม่ใน list |
| 9 | ตรวจสอบ database | Project ถูกสร้างใน `projects` table |

---

#### TC-ADMIN-PROJ-003: Add Project - Price Range Validation
**Priority:** High
**Role:** Admin

| Test Case | priceRangeMin | priceRangeMax | Expected Result |
|-----------|---------------|---------------|-----------------|
| 3a | (empty) | 5000000 | แสดง error "กรุณากรอกราคาต่ำสุด" |
| 3b | 3000000 | (empty) | แสดง error "กรุณากรอกราคาสูงสุด" |
| 3c | 5000000 | 3000000 | แสดง error "ราคาสูงสุดต้องมากกว่าหรือเท่ากับราคาต่ำสุด" |
| 3d | 3000000 | 5000000 | Success ✅ |
| 3e | 3000000 | 3000000 | Success ✅ (เท่ากันได้) |

---

#### TC-ADMIN-PROJ-004: Add Project - Field Validations
**Priority:** High
**Role:** Admin

| Test Case | Field | Input | Expected Result |
|-----------|-------|-------|-----------------|
| 4a | projectCode | (empty) | แสดง error "กรุณากรอกรหัสโครงการ" |
| 4b | projectCode | "PROJ001" (duplicate) | แสดง error "รหัสโครงการนี้ถูกใช้งานแล้ว" |
| 4c | projectName | (empty) | แสดง error "กรุณากรอกชื่อโครงการ" |
| 4d | projectType | (empty) | แสดง error "กรุณาเลือกประเภทโครงการ" |

---

#### TC-ADMIN-PROJ-005: Project Type Selection
**Priority:** Medium
**Role:** Admin

| Project Type | Value | Expected Label |
|--------------|-------|----------------|
| condo | condo | คอนโด |
| house | house | บ้านเดี่ยว |
| townhome | townhome | ทาวน์โฮม |
| commercial | commercial | พาณิชย์ |

---

#### TC-ADMIN-PROJ-006: Edit Project
**Priority:** High
**Role:** Admin
**Precondition:** มี project ใน database

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "แก้ไข" (EditOutlined) ของ project | เปลี่ยนไปหน้า Project Form |
| 2 | ตรวจสอบ form | ข้อมูลเดิมถูก populate ใน form |
| 3 | แก้ไข projectName: "The Reserve Updated" | - |
| 4 | แก้ไข priceRangeMax: 9500000 | - |
| 5 | คลิกปุ่ม "บันทึก" | - |
| 6 | ตรวจสอบ response | แสดง success message "แก้ไขโครงการสำเร็จ" |
| 7 | ตรวจสอบ table | ข้อมูลถูกอัพเดท |
| 8 | ตรวจสอบ database | ข้อมูลถูกอัพเดทใน `projects` table |

---

#### TC-ADMIN-PROJ-007: Delete Project
**Priority:** Critical
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | คลิกปุ่ม "ลบ" (DeleteOutlined) ของ project | แสดง Popconfirm "คุณแน่ใจหรือไม่ที่จะลบโครงการนี้?" |
| 2 | คลิกปุ่ม "ตรวจสอบ" | - |
| 3 | ตรวจสอบ response | แสดง success message "ลบโครงการสำเร็จ" |
| 4 | ตรวจสอบ table | Project หายไปจาก list |
| 5 | ตรวจสอบ database | Project ถูกลบจาก `projects` table |

---

#### TC-ADMIN-PROJ-008: Project Status Toggle
**Priority:** Medium
**Role:** Admin

| Current isActive | Expected Tag Color | Expected Tag Text |
|------------------|-------------------|-------------------|
| true | Green | ใช้งาน |
| false | Red | ไม่ใช้งาน |

---

#### TC-ADMIN-PROJ-009: Back Button in Project Form
**Priority:** Low
**Role:** Admin

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | อยู่ในหน้า Project Form | - |
| 2 | คลิกปุ่ม "ย้อนกลับ" | กลับไปหน้า Project List |
| 3 | ตรวจสอบ form data | ข้อมูลที่กรอกไว้ถูก clear |

---

## 🧑‍💼 Test Cases - Agent Role

### Agent Dashboard Module

#### TC-AGENT-DASH-001: View Agent Dashboard
**Priority:** Critical
**Role:** Agent
**Precondition:** Logged in as agent (status: active)

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login ด้วย agent account | Redirect ไปที่ `/agent/dashboard` |
| 2 | ตรวจสอบ dashboard | แสดง Agent Dashboard |
| 3 | ตรวจสอบ profile card | แสดงข้อมูลส่วนตัว:<br>- รหัสเอเจนต์<br>- ชื่อ-นามสกุล<br>- อีเมล<br>- เบอร์โทร |
| 4 | ตรวจสอบ statistics | แสดงสถิติลูกค้าของตัวเอง |

---

#### TC-AGENT-DASH-002: View Own Customers Only
**Priority:** Critical
**Role:** Agent
**Precondition:** Agent มีลูกค้าบางส่วน, agents อื่นก็มีลูกค้า

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | อยู่ในหน้า Agent Dashboard | - |
| 2 | Scroll ลงมาดูรายการลูกค้า | แสดงเฉพาะลูกค้าของตัวเอง |
| 3 | ตรวจสอบ agentId ในแต่ละ customer | ทุก customer มี agentId = agent's id |
| 4 | เปิด browser console | ไม่มี console error |
| 5 | ตรวจสอบ Network tab → XHR | API call ไปที่ `/api/customers?agentId=X` |

**Expected API Call:**
```
GET /api/customers?agentId=5&status=all&page=1&limit=100
Authorization: Bearer <token>
```

---

#### TC-AGENT-DASH-003: Edit Agent Profile
**Priority:** Medium
**Role:** Agent

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | อยู่ในหน้า Agent Dashboard | - |
| 2 | คลิกปุ่ม "แก้ไขโปรไฟล์" (EditOutlined) | เปิด Edit Profile Modal หรือ inline edit |
| 3 | แก้ไข phone: "0899999999" | - |
| 4 | คลิกปุ่ม "บันทึก" | - |
| 5 | ตรวจสอบ response | แสดง success notification "อัพเดทโปรไฟล์สำเร็จ" |
| 6 | ตรวจสอบ profile card | เบอร์โทรถูกอัพเดท |
| 7 | ตรวจสอบ database | `agents.phone` ถูกอัพเดท |

---

#### TC-AGENT-DASH-004: Agent Cannot Access Admin Features
**Priority:** Critical
**Role:** Agent
**Precondition:** Logged in as agent

| Test | URL | Expected Result |
|------|-----|-----------------|
| 4a | `/admin/dashboard` | Redirect ไปที่ `/agent/dashboard` หรือแสดง "Unauthorized" |
| 4b | ดูเมนู sidebar | ไม่มี "Agent Management", "Customer Management", "Project Management" |
| 4c | ดูเมนู sidebar | มีเฉพาะ "Dashboard" และ "Profile" |

---

#### TC-AGENT-DASH-005: Agent Cannot CRUD Customers via API
**Priority:** Critical
**Role:** Agent
**Precondition:** Logged in as agent

**Test via Browser Console or Postman:**

| Test | API Call | Expected Result |
|------|----------|-----------------|
| 5a | POST /api/customers | 403 Forbidden "บทบาท agent ไม่มีสิทธิ์เข้าถึงรีซอร์สนี้" |
| 5b | PUT /api/customers/:id | 403 Forbidden |
| 5c | DELETE /api/customers/:id | 403 Forbidden |
| 5d | GET /api/customers (without agentId filter) | 403 Forbidden หรือแสดงเฉพาะของตัวเอง |

**Expected API Response:**
```json
{
  "success": false,
  "message": "บทบาท agent ไม่มีสิทธิ์เข้าถึงรีซอร์สนี้"
}
```

---

#### TC-AGENT-DASH-006: Agent Cannot Access Other Agents' Customers
**Priority:** Critical
**Role:** Agent
**Precondition:** มี agent A และ agent B, แต่ละคนมีลูกค้าของตัวเอง

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login ด้วย Agent A | - |
| 2 | ดูรายการลูกค้า | แสดงเฉพาะลูกค้าของ Agent A |
| 3 | Logout | - |
| 4 | Login ด้วย Agent B | - |
| 5 | ดูรายการลูกค้า | แสดงเฉพาะลูกค้าของ Agent B |
| 6 | ตรวจสอบ customer list | ไม่เห็นลูกค้าของ Agent A เลย |

**Test via API (Advanced):**
```bash
# Login as Agent A, get token
# Try to call: GET /api/customers?agentId=B_ID
# Expected: 403 Forbidden or empty array
```

---

#### TC-AGENT-DASH-007: Agent Menu Structure
**Priority:** Medium
**Role:** Agent

| Menu Item | Visible | Functional |
|-----------|---------|------------|
| Dashboard | ✅ Yes | ✅ Yes |
| Profile | ✅ Yes | ✅ Yes |
| Agent Management | ❌ No | - |
| Customer Management | ❌ No | - |
| Project Management | ❌ No | - |
| Settings | (Optional) | - |

---

## 🔄 Test Cases - Cross-Role Testing

### TC-CROSS-001: Role-Based Dashboard Redirect
**Priority:** Critical

| User Role | Login Success | Expected Redirect | Actual Dashboard |
|-----------|---------------|-------------------|------------------|
| admin | ✅ | `/admin/dashboard` | Admin Dashboard |
| manager | ✅ | `/admin/dashboard` | Admin Dashboard |
| agent | ✅ | `/agent/dashboard` | Agent Dashboard |

---

### TC-CROSS-002: Public Route Access by Authenticated Users
**Priority:** Medium

| User Status | Route | Expected Result |
|-------------|-------|-----------------|
| Not logged in | `/login` | แสดงหน้า Login |
| Not logged in | `/register-agent` | แสดงหน้า Register |
| Logged in (admin) | `/login` | Redirect ไปที่ `/admin/dashboard` |
| Logged in (agent) | `/login` | Redirect ไปที่ `/agent/dashboard` |
| Logged in (admin) | `/register-agent` | Redirect ไปที่ `/admin/dashboard` |

---

### TC-CROSS-003: Manager Role Permissions
**Priority:** High
**Role:** Manager
**Precondition:** มี user account ที่ role = 'manager'

| Test | Action | Expected Result |
|------|--------|-----------------|
| 3a | Login ด้วย manager account | Redirect ไปที่ `/admin/dashboard` |
| 3b | เข้า Agent Management | แสดงและใช้งานได้ (เหมือน admin) |
| 3c | เข้า Customer Management | แสดงและใช้งานได้ (เหมือน admin) |
| 3d | เข้า Project Management | แสดงและใช้งานได้ (เหมือน admin) |
| 3e | ทดสอบ CRUD operations | ทุกอย่างทำงานได้ (เหมือน admin) |

---

### TC-CROSS-004: Switch Between Roles (Same Browser Session)
**Priority:** Medium

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login ด้วย admin account | เข้า Admin Dashboard |
| 2 | Logout | Redirect ไปที่ `/login` |
| 3 | Login ด้วย agent account | เข้า Agent Dashboard |
| 4 | ตรวจสอบ localStorage | user.role = 'agent' |
| 5 | ตรวจสอบ menu items | แสดงเฉพาะ agent menu |

---

### TC-CROSS-005: Concurrent Sessions (Multiple Tabs/Browsers)
**Priority:** Low

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Browser A: Login as admin | เข้า Admin Dashboard |
| 2 | Browser B: Login as agent | เข้า Agent Dashboard |
| 3 | Browser A: ทำงานต่อ | ยังคงเป็น admin session |
| 4 | Browser B: ทำงานต่อ | ยังคงเป็น agent session |
| 5 | Browser A: Logout | Browser A redirect ไปที่ `/login` |
| 6 | Browser B: ตรวจสอบ | ยังคง login อยู่ (independent session) |

---

## 🔗 Test Cases - Integration Testing

### TC-INT-001: End-to-End Agent Registration → Approval → Login
**Priority:** Critical

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | ไปที่ `/register-agent` | แสดงหน้า Registration Form |
| 2 | กรอกข้อมูลครบและ submit | Success "กรุณารอการอนุมัติ" |
| 3 | ตรวจสอบ database | Agent ถูกสร้างด้วย status: 'inactive'<br>User ถูกสร้างด้วย role: 'agent', isActive: false |
| 4 | ทดสอบ login ด้วย agent account | Login ล้มเหลว "รอการอนุมัติ" |
| 5 | Login ด้วย admin account | - |
| 6 | ไป Agent Management → Filter "Inactive" | เห็น agent ที่เพิ่งลงทะเบียน |
| 7 | คลิกปุ่ม approve (CheckOutlined) | Success "อนุมัติเอเจนต์สำเร็จ" |
| 8 | ตรวจสอบ database | status = 'active', isActive = true |
| 9 | Logout admin | - |
| 10 | Login ด้วย agent account | Login สำเร็จ เข้า Agent Dashboard |

---

### TC-INT-002: Create Agent → Assign Customer → View in Both Dashboards
**Priority:** High

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login as admin | - |
| 2 | ไป Agent Management → เพิ่ม agent ใหม่ (AG999) | Success |
| 3 | ไป Customer Management → เพิ่ม customer ใหม่ | - |
| 4 | เลือก agentId = AG999 | - |
| 5 | บันทึก customer | Success |
| 6 | ตรวจสอบ Customer Management table | Customer แสดงใน column "เอเจนต์" เป็น "AG999 - ..." |
| 7 | Logout admin | - |
| 8 | Login ด้วย AG999 agent account | - |
| 9 | ไป Agent Dashboard | แสดง customer ที่เพิ่งสร้าง |
| 10 | ตรวจสอบ customer count | Statistics แสดง 1 customer |

---

### TC-INT-003: Create Project → Assign to Customer → Display in Dropdown
**Priority:** High

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login as admin | - |
| 2 | ไป Project Management → เพิ่มโครงการใหม่ (PROJ998) | Success |
| 3 | ตรวจสอบ Project List | โครงการใหม่แสดงใน table |
| 4 | ไป Customer Management → เพิ่ม customer ใหม่ | - |
| 5 | คลิก Project dropdown (searchable) | แสดงโครงการทั้งหมดรวม PROJ998 |
| 6 | พิมพ์ "PROJ998" ใน search | กรองแสดงเฉพาะ PROJ998 |
| 7 | เลือก PROJ998 | - |
| 8 | บันทึก customer | Success |
| 9 | ตรวจสอบ Customer table | Column "โครงการที่สนใจ" แสดงชื่อโครงการถูกต้อง |

---

### TC-INT-004: Delete Agent with Customers (Foreign Key Constraint)
**Priority:** High

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | สร้าง agent ใหม่ (AG888) | Success |
| 2 | สร้าง customer ที่ assign ให้ AG888 | Success |
| 3 | ไป Agent Management | - |
| 4 | ลบ AG888 | แสดง error "ไม่สามารถลบเอเจนต์ได้ เนื่องจากมีลูกค้าที่เกี่ยวข้อง" |
| 5 | ตรวจสอบ database | Agent ยังคงอยู่ (ไม่ถูกลบ) |

---

### TC-INT-005: Dashboard Statistics Real-Time Update
**Priority:** Medium

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | Login as admin → ดู Dashboard | Total Agents = 6 (ตัวอย่าง) |
| 2 | ไป Agent Management → เพิ่ม agent ใหม่ | Success |
| 3 | กลับไป Dashboard (refresh หรือ navigate) | Total Agents = 7 |
| 4 | ไป Customer Management → เพิ่ม customer | Success |
| 5 | กลับไป Dashboard (refresh) | Total Customers เพิ่มขึ้น 1 |

---

### TC-INT-006: Thai Character Encoding End-to-End
**Priority:** Critical

| Step | Action | Expected Result |
|------|--------|-----------------|
| 1 | เพิ่ม agent ด้วยชื่อไทย "สุชาติ ทดสอบ" | - |
| 2 | ตรวจสอบ Agent table | แสดงเป็น "สุชาติ ทดสอบ" (ไม่ใช่ garbled text) |
| 3 | ตรวจสอบ phpMyAdmin | แสดงเป็น "สุชาติ ทดสอบ" |
| 4 | เพิ่ม customer ด้วยชื่อไทย "วิชาญ ลูกค้า" | - |
| 5 | ตรวจสอบ Customer table | แสดงเป็น "วิชาญ ลูกค้า" |
| 6 | Login ด้วย agent account | Dashboard แสดงชื่อไทยถูกต้อง |
| 7 | ตรวจสอบ browser console | ไม่มี encoding warnings |

**Database Configuration Required:**
```javascript
// backend/src/config/database.js
charset: 'utf8mb4',
collate: 'utf8mb4_unicode_ci'
```

---

## 🎨 Test Cases - UI/UX Testing

### TC-UI-001: Responsive Design - Desktop
**Priority:** Medium
**Browser:** Chrome, Firefox, Safari, Edge
**Screen Size:** 1920x1080, 1366x768

| Page | Element | Expected Behavior |
|------|---------|-------------------|
| Dashboard | Statistics Cards | แสดงเป็น Row (4-6 cards per row) |
| Dashboard | Charts | แสดง 2 charts per row |
| Agent Management | Table | Table ไม่ overflow, แสดง scrollbar ถ้าจำเป็น |
| Customer Management | Table | Horizontal scroll ถ้า columns เยอะเกิน |

---

### TC-UI-002: Responsive Design - Tablet
**Priority:** Medium
**Screen Size:** 768x1024 (iPad)

| Page | Element | Expected Behavior |
|------|---------|-------------------|
| Dashboard | Sidebar | Collapsible sidebar |
| Dashboard | Statistics Cards | แสดง 2-3 cards per row |
| Tables | Columns | บาง columns ซ่อนใน tablet view |

---

### TC-UI-003: Responsive Design - Mobile
**Priority:** Low
**Screen Size:** 375x667 (iPhone SE), 414x896 (iPhone 11)

| Page | Element | Expected Behavior |
|------|---------|-------------------|
| Login | Form | Full width, centered |
| Dashboard | Sidebar | Collapsed by default |
| Tables | Columns | แสดงเฉพาะ essential columns |

---

### TC-UI-004: Dark/Light Mode (ถ้ามี)
**Priority:** Low

| Theme | Expected Behavior |
|-------|-------------------|
| Light | Default colors |
| Dark | Dark background, light text |

---

### TC-UI-005: Loading States
**Priority:** Medium

| Action | Expected Loading Indicator |
|--------|----------------------------|
| Login | Button แสดง loading spinner |
| Fetch agents/customers | Table แสดง Spin component |
| Save form | Button disabled + loading |
| Delete | Confirmation modal → loading |

---

### TC-UI-006: Empty States
**Priority:** Low

| Page | Condition | Expected Empty State |
|------|-----------|----------------------|
| Agent Management | ไม่มี agents | แสดง "ไม่พบข้อมูลเอเจนต์" + ปุ่มเพิ่ม |
| Customer Management | ไม่มี customers | แสดง "ไม่พบข้อมูลลูกค้า" + ปุ่มเพิ่ม |
| Agent Dashboard | Agent ไม่มีลูกค้า | แสดง "คุณยังไม่มีลูกค้า" |

---

### TC-UI-007: Notification Messages
**Priority:** Medium

| Action | Expected Notification | Type |
|--------|----------------------|------|
| Login success | (ไม่แสดง - redirect เลย) | - |
| Add agent success | "เพิ่มเอเจนต์สำเร็จ" | Success (green) |
| Edit agent success | "อัพเดทข้อมูลเอเจนต์สำเร็จ" | Success |
| Delete agent success | "ลบเอเจนต์สำเร็จ" | Success |
| Validation error | "กรุณากรอกข้อมูลให้ครบ" | Error (red) |
| API error | "เกิดข้อผิดพลาด: [message]" | Error |

---

### TC-UI-008: Table Pagination
**Priority:** Medium

| Test | Action | Expected Result |
|------|--------|-----------------|
| 8a | มี agents > 10 records | แสดง pagination |
| 8b | คลิกหน้า 2 | แสดง records 11-20 |
| 8c | เปลี่ยน page size (10 → 20) | แสดง 20 records per page |
| 8d | ตรวจสอบ URL query | URL มี ?page=2&limit=20 |

---

### TC-UI-009: Modal Behavior
**Priority:** Medium

| Test | Action | Expected Result |
|------|--------|-----------------|
| 9a | เปิด Add Agent Modal | Modal แสดง, backdrop dimmed |
| 9b | คลิกนอก modal (backdrop) | Modal ไม่ปิด (ป้องกัน accidental close) |
| 9c | กด ESC key | Modal ปิด (ถ้า allow) |
| 9d | คลิกปุ่ม "ยกเลิก" | Modal ปิด, form reset |
| 9e | Submit success | Modal ปิดอัตโนมัติ, แสดง notification |

---

### TC-UI-010: Form Field Interactions
**Priority:** Low

| Test | Action | Expected Result |
|------|--------|-----------------|
| 10a | กรอก email ไม่ถูกต้อง → blur | แสดง error message ใต้ field |
| 10b | กรอก email ถูกต้อง → blur | Error message หาย |
| 10c | Submit form ที่ validation fail | Focus ไปที่ field แรกที่ error |
| 10d | Hover button | Cursor เป็น pointer, สีเปลี่ยน |

---

## 🔒 Test Cases - Security Testing

### TC-SEC-001: SQL Injection Protection
**Priority:** Critical

| Test | Input | Expected Result |
|------|-------|-----------------|
| 1a | Login email: `admin' OR '1'='1` | Login fail (ไม่ bypass) |
| 1b | Search agent: `'; DROP TABLE agents; --` | No SQL error, safe search |
| 1c | Customer name: `<script>alert('XSS')</script>` | ข้อความถูก escape, ไม่ execute script |

---

### TC-SEC-002: XSS (Cross-Site Scripting) Protection
**Priority:** Critical

| Test | Input | Expected Result |
|------|-------|-----------------|
| 2a | Agent name: `<script>alert('XSS')</script>` | แสดงเป็น text (ไม่ execute) |
| 2b | Customer address: `<img src=x onerror=alert('XSS')>` | แสดงเป็น text |
| 2c | Project name: `<a href="javascript:alert()">Click</a>` | แสดงเป็น text |

---

### TC-SEC-003: Password Security
**Priority:** Critical

| Test | Action | Expected Result |
|------|--------|-----------------|
| 3a | ตรวจสอบ database → users.password | เป็น bcrypt hash (60 characters, starts with $2b$) |
| 3b | ทดสอบ login ด้วย password ที่เหมือนกัน 2 ครั้ง | ทั้ง 2 ครั้ง login สำเร็จ (hash comparison ทำงาน) |
| 3c | ดู Network tab → Login request | Password ส่งเป็น plain text ใน HTTPS body (ไม่แสดงใน URL) |
| 3d | ดู API response | ไม่มี password field ใน response |

**Expected Password Hash Format:**
```
$2b$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy
```

---

### TC-SEC-004: JWT Token Security
**Priority:** Critical

| Test | Action | Expected Result |
|------|--------|-----------------|
| 4a | Inspect token (jwt.io) | Payload มี { id, iat, exp }, ไม่มี password |
| 4b | Copy token ไป decode | ดูได้ payload แต่ verify signature fail (ถ้าไม่มี secret) |
| 4c | เปลี่ยน token payload (เช่น id: 1 → 999) | API return 401 Unauthorized (signature invalid) |
| 4d | Remove token → call API | API return 401 "ไม่พบ Token การเข้าถึงถูกปฏิเสธ" |

---

### TC-SEC-005: HTTPS/TLS (Production Only)
**Priority:** High
**Environment:** Production

| Test | Action | Expected Result |
|------|--------|-----------------|
| 5a | เข้า http://172.22.22.11:3000 | Auto redirect ไปที่ https:// (ถ้า setup แล้ว) |
| 5b | ตรวจสอบ SSL certificate | Valid certificate, ไม่มี browser warning |
| 5c | ตรวจสอบ Network tab → Headers | `Strict-Transport-Security` header |

---

### TC-SEC-006: Session Management
**Priority:** High

| Test | Action | Expected Result |
|------|--------|-----------------|
| 6a | Login → ตรวจสอบ localStorage | มี token และ user object |
| 6b | Close tab → เปิดใหม่ | ยังคง login อยู่ (persistent session) |
| 6c | Logout | token และ user ถูกลบจาก localStorage |
| 6d | Login ใน browser A → logout ใน browser B (same account) | Browser A ยังคง login (independent session) |

---

### TC-SEC-007: CORS Configuration
**Priority:** Critical

| Test | Origin | Expected Result |
|------|--------|-----------------|
| 7a | http://localhost:3000 | Allowed ✅ |
| 7b | http://172.22.22.11:3000 | Allowed ✅ |
| 7c | http://malicious-site.com | Blocked ❌ CORS error |
| 7d | ตรวจสอบ Response Headers | `Access-Control-Allow-Origin: http://localhost:3000` |

---

### TC-SEC-008: API Rate Limiting (ถ้ามี)
**Priority:** Low

| Test | Action | Expected Result |
|------|--------|-----------------|
| 8a | ทำ login request 100 ครั้งใน 1 นาที | ถ้ามี rate limit: request ที่ 101 fail "Too many requests" |

---

### TC-SEC-009: Role-Based Authorization Bypass Attempts
**Priority:** Critical

**Test via Postman or Browser Console:**

| Test | Action | Expected Result |
|------|--------|-----------------|
| 9a | Login as agent → เปลี่ยน role ใน localStorage เป็น 'admin' → refresh | Frontend อาจแสดง admin menu แต่ API calls ยัง fail 403 |
| 9b | Login as agent → call POST /api/agents (create agent) | 403 Forbidden |
| 9c | Login as agent → call GET /api/customers (ไม่ใส่ agentId) | 403 Forbidden หรือ empty array |

---

## ⚡ Test Cases - Performance Testing

### TC-PERF-001: Page Load Time
**Priority:** Medium

| Page | Expected Load Time | Acceptable |
|------|-------------------|------------|
| Login | < 1 second | < 2 seconds |
| Dashboard | < 2 seconds | < 3 seconds |
| Agent Management (100 records) | < 2 seconds | < 4 seconds |
| Customer Management (500 records) | < 3 seconds | < 5 seconds |

**Measurement Tool:** Chrome DevTools → Network tab → DOMContentLoaded, Load events

---

### TC-PERF-002: API Response Time
**Priority:** Medium

| API Endpoint | Expected Response Time | Acceptable |
|--------------|------------------------|------------|
| POST /api/auth/login | < 500ms | < 1000ms |
| GET /api/agents | < 300ms | < 800ms |
| GET /api/customers | < 500ms | < 1500ms |
| POST /api/agents | < 400ms | < 1000ms |
| PUT /api/customers/:id | < 300ms | < 800ms |

**Measurement Tool:** Postman, Chrome DevTools Network tab

---

### TC-PERF-003: Database Query Performance
**Priority:** Medium

| Query | Expected Time | Acceptable |
|-------|---------------|------------|
| SELECT * FROM agents WHERE status = 'active' | < 50ms | < 200ms |
| SELECT * FROM customers JOIN agents | < 100ms | < 500ms |
| INSERT INTO agents | < 30ms | < 100ms |

**Measurement Tool:** MySQL slow query log, EXPLAIN query

---

### TC-PERF-004: Large Dataset Handling
**Priority:** Low

| Test | Dataset Size | Expected Result |
|------|--------------|-----------------|
| 4a | Load 1000 agents | Table loads within 5 seconds, pagination works |
| 4b | Load 5000 customers | Table loads, ไม่ browser freeze |
| 4c | Search 10000 records | Results within 3 seconds |

---

### TC-PERF-005: Concurrent Users
**Priority:** Low
**Tool:** JMeter, k6, Artillery

| Test | Concurrent Users | Expected Result |
|------|------------------|-----------------|
| 5a | 10 users login simultaneously | All succeed, < 2 seconds each |
| 5b | 50 users browsing dashboard | No errors, acceptable load time |
| 5c | 100 users CRUD operations | Database handles load, ไม่มี deadlocks |

---

### TC-PERF-006: Memory Leaks (Frontend)
**Priority:** Low

| Test | Action | Expected Result |
|------|--------|-----------------|
| 6a | เปิด Dashboard → ดู Chrome DevTools Memory tab | Memory usage stable |
| 6b | Navigate ระหว่างหน้าต่างๆ 50 ครั้ง | Memory ไม่เพิ่มขึ้นเรื่อยๆ (no leak) |
| 6c | เปิด/ปิด Modal 100 ครั้ง | Memory usage กลับสู่ baseline |

---

### TC-PERF-007: Bundle Size (Frontend)
**Priority:** Low

| Metric | Expected Value | Acceptable |
|--------|----------------|------------|
| Initial JS bundle size | < 500 KB | < 1 MB |
| Initial CSS bundle size | < 100 KB | < 300 KB |
| Total page weight | < 1 MB | < 3 MB |

**Measurement Tool:** `npm run build` → check dist/ folder size

---

## 🚨 Bug Severity Classification

### Severity 1 - Critical (ต้องแก้ทันที)
- ระบบ crash หรือ unavailable
- Security vulnerabilities (SQL injection, XSS)
- Data loss หรือ corruption
- Login ไม่ได้
- Authorization bypass

### Severity 2 - High (แก้โดยเร็ว)
- Feature หลักใช้งานไม่ได้ (เช่น ไม่สามารถเพิ่ม customer)
- API errors ที่ block การใช้งาน
- Incorrect data display (Thai characters garbled)
- Performance issues ที่ severe

### Severity 3 - Medium (แก้ในรอบถัดไป)
- UI bugs (button alignment, colors ผิด)
- Validation errors ที่ไม่ชัดเจน
- Minor performance issues
- Missing error messages

### Severity 4 - Low (แก้เมื่อมีเวลา)
- Typos, spelling mistakes
- Cosmetic issues
- Enhancement requests
- Nice-to-have features

---

## 📊 Test Execution Tracking

### Test Execution Template

```markdown
| Test Case ID | Description | Status | Tester | Date | Notes |
|--------------|-------------|--------|--------|------|-------|
| TC-AUTH-001 | Login with Admin Account | ✅ Pass | John | 2025-10-22 | - |
| TC-AUTH-002 | Login with Agent Account | ❌ Fail | Jane | 2025-10-22 | Agent cannot login - bug filed |
| TC-ADMIN-AGENT-001 | View All Agents | ⏳ In Progress | Bob | - | - |
| TC-UI-005 | Loading States | ⏸️ Blocked | Alice | - | Waiting for API fix |
```

**Status Codes:**
- ✅ **Pass** - Test passed
- ❌ **Fail** - Test failed (bug found)
- ⏳ **In Progress** - Currently testing
- ⏸️ **Blocked** - Cannot test (dependency issue)
- ⏭️ **Skipped** - Not applicable or skipped
- 🔄 **Retest** - Need to retest after fix

---

### Test Coverage Summary

| Module | Total Test Cases | Pass | Fail | In Progress | Coverage % |
|--------|------------------|------|------|-------------|------------|
| Authentication | 10 | 0 | 0 | 0 | 0% |
| Admin - Dashboard | 3 | 0 | 0 | 0 | 0% |
| Admin - Agent Mgmt | 11 | 0 | 0 | 0 | 0% |
| Admin - Customer Mgmt | 9 | 0 | 0 | 0 | 0% |
| Admin - Project Mgmt | 9 | 0 | 0 | 0 | 0% |
| Agent - Dashboard | 7 | 0 | 0 | 0 | 0% |
| Cross-Role | 5 | 0 | 0 | 0 | 0% |
| Integration | 6 | 0 | 0 | 0 | 0% |
| UI/UX | 10 | 0 | 0 | 0 | 0% |
| Security | 9 | 0 | 0 | 0 | 0% |
| Performance | 7 | 0 | 0 | 0 | 0% |
| **TOTAL** | **86** | **0** | **0** | **0** | **0%** |

---

## 🎯 Test Execution Priority

### Phase 1: Critical Path (ต้องผ่านก่อน)
1. TC-AUTH-001 - Login with Admin
2. TC-AUTH-002 - Login with Agent
3. TC-AUTH-006 - Access Protected Route Without Token
4. TC-ADMIN-AGENT-005 - Add New Agent
5. TC-ADMIN-CUST-005 - Add New Customer
6. TC-AGENT-DASH-002 - View Own Customers Only

### Phase 2: Core Features
1. All Admin CRUD operations (Agents, Customers, Projects)
2. All Agent Dashboard features
3. Cross-Role tests
4. Integration tests

### Phase 3: Quality & Polish
1. UI/UX tests
2. Security tests
3. Performance tests

---

## 📝 Test Data Requirements

### Test Users
```sql
-- Admin user
INSERT INTO users (email, password, role, is_active) VALUES
('admin@test.com', '$2b$10$hashedpassword', 'admin', true);

-- Agent user (active)
INSERT INTO users (email, password, role, is_active) VALUES
('agent.active@test.com', '$2b$10$hashedpassword', 'agent', true);

-- Agent user (inactive - pending approval)
INSERT INTO users (email, password, role, is_active) VALUES
('agent.pending@test.com', '$2b$10$hashedpassword', 'agent', false);
```

### Test Agents
- อย่างน้อย 3 agents ต่าง status (active, inactive, suspended)
- Agent ที่มีลูกค้า และ Agent ที่ไม่มีลูกค้า

### Test Customers
- ลูกค้าของ agent ต่างๆ
- ลูกค้าต่าง status (active, inactive, pending)
- ลูกค้าที่มี project และไม่มี project

### Test Projects
- อย่างน้อย 3 projects ต่าง type
- Projects ที่ active และ inactive

---

## 🏁 Test Sign-Off Criteria

ระบบพร้อม deploy เมื่อ:
- ✅ Critical test cases (Severity 1) ผ่านทั้งหมด 100%
- ✅ High priority test cases (Severity 2) ผ่านอย่างน้อย 95%
- ✅ Medium priority test cases (Severity 3) ผ่านอย่างน้อย 85%
- ✅ No critical bugs open
- ✅ No high severity bugs open > 3 items
- ✅ Performance benchmarks met
- ✅ Security testing passed
- ✅ UAT approved by stakeholders

---

## 📞 Contact & Support

**QA Team Lead:** [Name]
**Email:** qa@sena.co.th
**Issue Tracker:** GitHub Issues (https://github.com/karnworkspace/referralsena/issues)

---

**สรุป Test Cases ทั้งหมด: 86+ Test Cases**

| หมวดหมู่ | จำนวน Test Cases |
|----------|------------------|
| Authentication & Authorization | 10 |
| Admin Role - Dashboard | 3 |
| Admin Role - Agent Management | 11 |
| Admin Role - Customer Management | 9 |
| Admin Role - Project Management | 9 |
| Agent Role - Dashboard | 7 |
| Cross-Role Testing | 5 |
| Integration Testing | 6 |
| UI/UX Testing | 10 |
| Security Testing | 9 |
| Performance Testing | 7 |
| **รวม** | **86** |

---

**เอกสารนี้ครอบคลุม:**
- ✅ Role-based testing (Admin, Agent, Manager)
- ✅ CRUD operations ทุก modules
- ✅ Authentication & Authorization
- ✅ Thai character encoding
- ✅ Validation testing
- ✅ Integration workflows
- ✅ Security testing (SQL injection, XSS, JWT, CORS)
- ✅ Performance benchmarks
- ✅ UI/UX responsive design
- ✅ Bug severity classification
- ✅ Test execution tracking

**พร้อมใช้สำหรับ QA Team เริ่มทดสอบได้เลยครับ! 🚀**
