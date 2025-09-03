# Agent Referral System

ระบบจัดการเอเจนต์และการแนะนำลูกค้า สำหรับธุรกิจอสังหาริมทรัพย์

## Tech Stack

- **Frontend**: React 18 + Vite + Ant Design
- **Backend**: Node.js + Express.js + Sequelize ORM
- **Database**: MySQL 8.0+
- **Authentication**: JWT (JSON Web Token)

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

## Getting Started

### Prerequisites

- Node.js 18.0+
- MySQL 8.0+
- npm หรือ yarn

### Backend Setup

1. เข้าไปยังโฟลเดอร์ backend:
   ```bash
   cd backend
   ```

2. ติดตั้ง dependencies:
   ```bash
   npm install
   ```

3. Copy และแก้ไขไฟล์ environment:
   ```bash
   cp .env.example .env
   ```
   
   แก้ไขไฟล์ `.env`:
   ```env
   # Database Configuration
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=referral_system
   DB_USER=your_username
   DB_PASSWORD=your_password
   
   # JWT Configuration
   JWT_SECRET=your-super-secret-jwt-key
   ```

4. สร้างฐานข้อมูล:
   ```sql
   CREATE DATABASE referral_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. Import database schema:
   ```bash
   mysql -u your_username -p referral_system < ../database-schema.sql
   ```

6. เริ่มต้น development server:
   ```bash
   npm run dev
   ```

   Server จะรันที่: http://localhost:5000

### API Endpoints

#### Health Check
- `GET /health` - ตรวจสอบสถานะเซิร์ฟเวอร์
- `GET /api` - ข้อมูล API endpoints
- `GET /api/test-db` - ทดสอบการเชื่อมต่อฐานข้อมูล

#### Authentication
- `POST /api/auth/login` - เข้าสู่ระบบ
- `POST /api/auth/register` - ลงทะเบียน
- `GET /api/auth/me` - ข้อมูลผู้ใช้ปัจจุบัน
- `POST /api/auth/logout` - ออกจากระบบ

#### Test Login
```json
POST /api/auth/login
{
  "email": "admin@test.com",
  "password": "123456"
}
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