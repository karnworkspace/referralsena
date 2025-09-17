# SENA Agent Referral System

ระบบจัดการเอเจนต์และการแนะนำลูกค้า สำหรับธุรกิจอสังหาริมทรัพย์ พร้อมระบบติดตามการเปลี่ยนแปลงข้อมูลแบบอัตโนมัติ

## 🚀 Tech Stack

- **Frontend**: React 18 + Vite + Ant Design
- **Backend**: Node.js + Express.js + Sequelize ORM
- **Database**: MySQL 8.0 with Docker
- **Authentication**: JWT (JSON Web Token)
- **Deployment**: Docker + Docker Compose
- **Activity Logging**: MySQL Triggers + JSON Storage

## Project Structure

```
referral-system-new/
├── backend/                 # Node.js Backend API
│   ├── src/
│   │   ├── config/         # Database และ configuration
│   │   ├── models/         # Sequelize models
│   │   ├── controllers/    # API controllers
│   │   ├── routes/         # API routes
│   │   ├── middleware/     # Authentication, validation
│   │   ├── services/       # Business logic
│   │   └── utils/          # Helper functions
│   ├── uploads/            # File uploads
│   ├── scripts/            # Database scripts
│   └── tests/              # Unit tests
├── frontend/               # React Frontend
├── docs/                   # Documentation
└── database-schema.sql     # Database schema
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

หากต้องการ setup แบบ manual:

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
   mysql -u root -p sena_referral < customer-audit-triggers.sql
   mysql -u root -p sena_referral < init-database.sql
   ```

4. **แก้ไขไฟล์ Environment**
   ```env
   # backend/.env
   DB_HOST=localhost
   DB_PORT=3306
   DB_USER=root
   DB_PASSWORD=your_password
   DB_NAME=sena_referral
   JWT_SECRET=your-super-secret-jwt-key
   ```

5. **เริ่มต้น Services**
   ```bash
   # Terminal 1: Backend
   cd backend && npm run dev

   # Terminal 2: Frontend
   cd frontend && npm run dev
   ```

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
- `GET /api/agents` - ดึงรายการเอเจนต์ทั้งหมด
- `GET /api/agents/list` - ดึงรายชื่อเอเจนต์สำหรับ dropdown
- `GET /api/agents/:id` - ดึงข้อมูลเอเจนต์ตาม ID
- `PUT /api/agents/:id` - อัพเดทข้อมูลเอเจนต์
- `PUT /api/agents/profile` - แก้ไขข้อมูลส่วนตัว (เอเจนต์)

### Customers Management
- `GET /api/customers` - ดึงรายการลูกค้าทั้งหมด
- `GET /api/customers/:id` - ดึงข้อมูลลูกค้าตาม ID
- `POST /api/customers` - สร้างลูกค้าใหม่
- `PUT /api/customers/:id` - อัพเดทข้อมูลลูกค้า
- `DELETE /api/customers/:id` - ลบลูกค้า

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

### Error Troubleshooting

#### Common Issues

1. **Database Connection Error**
   - ตรวจสอบว่า MySQL server กำลังทำงาน
   - ตรวจสอบ username/password ในไฟล์ `.env`
   - ตรวจสอบว่าฐานข้อมูล `referral_system` ถูกสร้างแล้ว

2. **Port Already in Use**
   - เปลี่ยน PORT ในไฟล์ `.env`
   - หรือหยุด process ที่ใช้ port 5000

3. **Module Not Found Error**
   - รัน `npm install` ใหม่
   - ลบโฟลเดอร์ `node_modules` และ `package-lock.json` แล้วติดตั้งใหม่

4. **API Error 500**
   - ตรวจสอบ logs ใน console
   - ตรวจสอบการเชื่อมต่อฐานข้อมูล
   - ตรวจสอบไฟล์ `.env`

### Available Scripts

```bash
npm start       # เริ่ม production server
npm run dev     # เริ่ม development server with nodemon
npm test        # รัน tests
npm run db:migrate    # รัน database migrations
npm run db:seed       # เพิ่ม sample data
```

### Database Schema

ระบบใช้ฐานข้อมูลดังนี้:

- **users** - ข้อมูลผู้ใช้และการยืนยันตัวตน
- **agents** - ข้อมูลเอเจนต์
- **projects** - ข้อมูลโครงการ
- **customers** - ข้อมูลลูกค้า
- **visits** - ข้อมูลการนัดหมายชมโครงการ
- **sales** - ข้อมูลการขาย
- **leads** - ข้อมูล Lead
- **requests** - คำร้องต่างๆ
- **activity_logs** - บันทึกการใช้งาน

### Development

#### Adding New Features

1. สร้าง Model ใน `src/models/`
2. สร้าง Controller ใน `src/controllers/`
3. สร้าง Routes ใน `src/routes/`
4. เพิ่ม Validation ใน `src/middleware/validation.js`
5. เพิ่ม Tests ใน `tests/`

#### Code Style

- ใช้ CommonJS modules (require/module.exports)
- ใช้ async/await สำหรับ asynchronous operations
- Error handling ด้วย try-catch
- Response format: `{ success: boolean, message: string, data?: any }`

## Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.