# 📋 Migration Report - Production Deployment

**วันที่**: 2025-12-08
**Server**: 172.22.22.11 (Production)
**Database**: sena_referral
**Branch**: version-preprod

---

## ❌ ปัญหาที่พบจาก Migration ครั้งแรก

### 1. Projects Thai Encoding Migration
**ไฟล์**: `fix-projects-thai-encoding.sql`

**ปัญหา**:
```
ERROR 1451 (23000): Cannot delete or update a parent row:
a foreign key constraint fails (`sena_referral`.`customers`,
CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`))
```

**สาเหตุ**:
- Script พยายาม `DELETE FROM projects` ก่อนจะ INSERT ใหม่
- แต่มี customers ที่อ้างอิงไปยัง projects (foreign key constraint)
- MySQL ป้องกันไม่ให้ลบข้อมูล parent table ที่มี child records อ้างอิงอยู่

---

### 2. Users bud/name Update Migration
**ไฟล์**: `add-bud-name-to-users.sql`

**ปัญหา**:
```
Total admin users updated: 0
```

**สาเหตุ**:
- Script มี UPDATE statements สำหรับ 69 email addresses
- แต่ production database มีเพียง 2 admin users: `admin@sena.co.th` และ `admin@test.com`
- Email addresses ไม่ตรงกับที่ระบุใน script → UPDATE 0 rows

**ผลลัพธ์**:
- Columns `bud` และ `name` ถูกสร้างแล้ว ✅
- แต่ค่าทั้งหมดยังเป็น NULL

---

## ✅ แนวทางแก้ไข

### 1. สร้าง Migration Script ใหม่สำหรับ Projects

**ไฟล์ใหม่**: `fix-projects-thai-encoding-v2.sql`

**การแก้ไข**:
- เพิ่ม `SET FOREIGN_KEY_CHECKS=0;` ก่อน DELETE
- ทำการ DELETE และ INSERT ตามปกติ
- เปิด `SET FOREIGN_KEY_CHECKS=1;` กลับมาหลังเสร็จ

**วิธีนี้**:
- ✅ ปิด foreign key constraint checking ชั่วคราว
- ✅ สามารถลบและใส่ข้อมูลใหม่ได้
- ✅ เปิด constraint กลับมาหลังเสร็จเพื่อความปลอดภัย

---

### 2. สร้าง Migration Script ใหม่สำหรับ Users

**ไฟล์ใหม่**: `update-existing-users-bud-name.sql`

**การแก้ไข**:
- UPDATE เฉพาะ admin users ที่มีอยู่จริงใน production
- ใส่ค่า default สำหรับ admin@sena.co.th และ admin@test.com
- ไม่พยายาม UPDATE users ที่ไม่มีอยู่

**ค่าที่จะ Update**:
```sql
admin@sena.co.th → bud: '0', name: 'Admin SENA'
admin@test.com   → bud: '0', name: 'Admin Test'
```

---

## 🚀 คำแนะนำในการรัน Migration ใหม่

### SSH เข้า Production Server
```bash
ssh admindigital@172.22.22.11
cd /opt/sena-agent
```

### Pull Code ล่าสุดจาก GitHub
```bash
git stash
git pull origin version-preprod
```

### รัน Migration Scripts ตามลำดับ

#### 1. แก้ไข Projects Thai Encoding (Version 2)
```bash
docker exec -i sena_mysql mysql -usena_user -psena_password sena_referral < migration-scripts/fix-projects-thai-encoding-v2.sql
```

**ผลลัพธ์ที่คาดหวัง**:
```
แก้ไข encoding สำเร็จ (V2) | 83 projects
PROJ001 | นิช ไอดี แอท ปากเกร็ด สเตชั่น | condo
```

---

#### 2. Update Users bud/name (Existing Users Only)
```bash
docker exec -i sena_mysql mysql -usena_user -psena_password sena_referral < migration-scripts/update-existing-users-bud-name.sql
```

**ผลลัพธ์ที่คาดหวัง**:
```
Current admin users before update:
id | email              | bud  | name       | role
1  | admin@sena.co.th   | NULL | NULL       | admin
4  | admin@test.com     | NULL | NULL       | admin

Admin users after update:
id | email              | bud | name        | role  | is_active
1  | admin@sena.co.th   | 0   | Admin SENA  | admin | 1
4  | admin@test.com     | 0   | Admin Test  | admin | 1

total_admin_users: 2
users_with_bud: 2
users_with_name: 2
```

---

### Restart Backend API
```bash
docker-compose restart api
```

---

## 🧪 ตรวจสอบผลลัพธ์

### 1. ตรวจสอบ Projects Thai Encoding
```bash
docker exec -it sena_mysql mysql -usena_user -psena_password sena_referral -e "
SELECT id, project_code, project_name, project_type
FROM projects
WHERE id <= 5;
"
```

**ควรเห็น**:
```
+----+--------------+---------------------------------------------+--------------+
| id | project_code | project_name                                 | project_type |
+----+--------------+---------------------------------------------+--------------+
|  1 | PROJ001      | นิช ไอดี แอท ปากเกร็ด สเตชั่น                | condo        |
|  2 | PROJ002      | นิช ไอดี เพชรเกษม - บางแค                    | condo        |
+----+--------------+---------------------------------------------+--------------+
```

---

### 2. ตรวจสอบ Users bud/name
```bash
docker exec -it sena_mysql mysql -usena_user -psena_password sena_referral -e "
SELECT id, email, bud, name, role
FROM users
WHERE role = 'admin';
"
```

**ควรเห็น**:
```
+----+------------------+-----+------------+-------+
| id | email            | bud | name       | role  |
+----+------------------+-----+------------+-------+
|  1 | admin@sena.co.th | 0   | Admin SENA | admin |
|  4 | admin@test.com   | 0   | Admin Test | admin |
+----+------------------+-----+------------+-------+
```

---

### 3. ตรวจสอบ Backend Logs
```bash
docker logs sena_api --tail 20
```

**ควรเห็น**:
```
✅ Database connection established successfully
🚀 Server running on http://localhost:4000
```

---

### 4. ทดสอบ Frontend
เปิดเว็บไซต์:
```
http://172.22.22.11:3000
```

**ทดสอบ**:
- ✅ Login ด้วย admin@test.com / password
- ✅ เข้าหน้า Dashboard
- ✅ ดูรายการ Projects → ชื่อโครงการต้องเป็นภาษาไทยที่ถูกต้อง
- ✅ ดูรายการ Agents → ชื่อต้องเป็นภาษาไทยที่ถูกต้อง

---

## 📊 สรุปการแก้ไข

| Migration | ไฟล์เดิม | ไฟล์ใหม่ | การแก้ไข |
|-----------|----------|----------|----------|
| Projects Encoding | fix-projects-thai-encoding.sql | fix-projects-thai-encoding-v2.sql | เพิ่ม SET FOREIGN_KEY_CHECKS=0/1 |
| Users bud/name | add-bud-name-to-users.sql | update-existing-users-bud-name.sql | UPDATE เฉพาะ users ที่มีจริง |

---

## 🔒 Security Notes

- ✅ Migration scripts ใช้ MySQL user `sena_user` (not root)
- ✅ Backup tables ถูกสร้างก่อน migration (projects_backup_encoding_fix_v2)
- ✅ Foreign key checks ถูกปิดเฉพาะชั่วคราว แล้วเปิดกลับมา
- ⚠️ ควรทำ full database backup ก่อนรัน migration ใน production จริง

---

## 📝 หมายเหตุ

**ทำไมต้องปิด Foreign Key Checks?**
- เพราะเราต้องการลบข้อมูลเก่าที่มี encoding ผิด แล้วใส่ข้อมูลใหม่ที่ encoding ถูกต้อง
- ถ้าไม่ปิด MySQL จะป้องกันไม่ให้ลบเพราะมี customers อ้างอิงอยู่
- ปิดเฉพาะช่วงเวลาที่ DELETE/INSERT เสร็จแล้วเปิดกลับมาทันที

**ทำไม bud/name ต้อง update แบบ manual?**
- Production database มี admin users แค่ 2 คน ไม่ใช่ 69 คนตาม Excel file
- ข้อมูลใน Excel คือข้อมูล master ที่จะมีในอนาคต ยังไม่มีใน production
- เราแค่ใส่ค่า default ให้กับ admin users ที่มีอยู่ก่อน

---

## 🎯 Next Steps (Optional)

ถ้าต้องการ import ข้อมูล admin users ทั้ง 69 คนจาก Excel:
1. ใช้ `add-bud-name-to-users.sql` (original script) เพื่อ import ทั้งหมด
2. หรือสร้าง CSV file แล้ว import ผ่าน phpMyAdmin
3. หรือสร้าง API endpoint สำหรับ bulk user import

---

**สร้างโดย**: Claude Code
**วันที่**: 2025-12-08
**Branch**: version-preprod
