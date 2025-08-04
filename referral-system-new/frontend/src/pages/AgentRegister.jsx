import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { 
  Card, 
  Form, 
  Input, 
  Button, 
  Row, 
  Col, 
  Typography, 
  Space, 
  notification,
  Divider,
  Steps
} from 'antd';
import { 
  UserOutlined, 
  MailOutlined, 
  PhoneOutlined, 
  IdcardOutlined,
  LockOutlined,
  CheckCircleOutlined,
  TeamOutlined
} from '@ant-design/icons';
import { authAPI } from '../services/api';

const { Title, Text, Paragraph } = Typography;

const AgentRegister = () => {
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const [loading, setLoading] = useState(false);
  const [registrationSuccess, setRegistrationSuccess] = useState(false);
  const [agentInfo, setAgentInfo] = useState(null);

  const handleSubmit = async (values) => {
    setLoading(true);
    try {
      const response = await authAPI.registerAgent(values);
      setAgentInfo(response.data);
      setRegistrationSuccess(true);
      notification.success({
        message: 'ลงทะเบียนสำเร็จ',
        description: response.message,
        duration: 5,
      });
    } catch (error) {
      notification.error({
        message: 'เกิดข้อผิดพลาด',
        description: error.message || 'ไม่สามารถลงทะเบียนได้',
      });
    } finally {
      setLoading(false);
    }
  };

  const steps = [
    {
      title: 'กรอกข้อมูล',
      icon: <UserOutlined />
    },
    {
      title: 'รอการอนุมัติ',
      icon: <CheckCircleOutlined />
    },
    {
      title: 'เริ่มใช้งาน',
      icon: <TeamOutlined />
    }
  ];

  if (registrationSuccess) {
    return (
      <div style={{ 
        minHeight: '100vh', 
        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        padding: '20px'
      }}>
        <Card 
          style={{ 
            width: '100%', 
            maxWidth: '600px',
            borderRadius: '12px',
            boxShadow: '0 20px 40px rgba(0,0,0,0.1)'
          }}
        >
          <div style={{ textAlign: 'center', padding: '20px 0' }}>
            <CheckCircleOutlined 
              style={{ 
                fontSize: '64px', 
                color: '#52c41a', 
                marginBottom: '20px' 
              }} 
            />
            <Title level={2} style={{ color: '#52c41a', marginBottom: '8px' }}>
              ลงทะเบียนเรียบร้อย!
            </Title>
            
            <Card 
              style={{ 
                marginTop: '24px', 
                backgroundColor: '#f6ffed',
                border: '1px solid #b7eb8f'
              }}
            >
              <Row gutter={16}>
                <Col span={12}>
                  <Text strong>รหัสเอเจนต์:</Text>
                  <br />
                  <Text style={{ fontSize: '18px', color: '#1890ff' }}>
                    {agentInfo?.agentCode}
                  </Text>
                </Col>
                <Col span={12}>
                  <Text strong>สถานะ:</Text>
                  <br />
                  <Text style={{ fontSize: '16px', color: '#faad14' }}>
                    รอการอนุมัติ
                  </Text>
                </Col>
              </Row>
              <Divider />
              <Text strong>ชื่อ-นามสกุล:</Text>
              <br />
              <Text style={{ fontSize: '16px' }}>
                {agentInfo?.firstName} {agentInfo?.lastName}
              </Text>
            </Card>

            <Steps 
              current={1} 
              items={steps} 
              style={{ marginTop: '32px' }}
            />

            <Paragraph style={{ marginTop: '24px', color: '#666' }}>
              ข้อมูลของคุณถูกส่งไปยังผู้ดูแลระบบเพื่อการอนุมัติแล้ว
              <br />
              คุณจะได้รับอีเมลแจ้งเตือนเมื่อบัญชีของคุณได้รับการอนุมัติ
            </Paragraph>

            <Space size="middle" style={{ marginTop: '24px' }}>
              <Button 
                type="primary" 
                onClick={() => navigate('/login')}
                size="large"
              >
                ไปหน้าเข้าสู่ระบบ
              </Button>
              <Button 
                onClick={() => {
                  setRegistrationSuccess(false);
                  setAgentInfo(null);
                  form.resetFields();
                }}
                size="large"
              >
                ลงทะเบียนอีกครั้ง
              </Button>
            </Space>
          </div>
        </Card>
      </div>
    );
  }

  return (
    <div style={{ 
      minHeight: '100vh', 
      background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      padding: '20px'
    }}>
      <Card 
        style={{ 
          width: '100%', 
          maxWidth: '600px',
          borderRadius: '12px',
          boxShadow: '0 20px 40px rgba(0,0,0,0.1)'
        }}
      >
        <div style={{ textAlign: 'center', marginBottom: '32px' }}>
          <TeamOutlined style={{ fontSize: '48px', color: '#1890ff', marginBottom: '16px' }} />
          <Title level={2} style={{ margin: 0 }}>
            สมัครเป็นเอเจนต์
          </Title>
          <Text type="secondary">
            กรอกข้อมูลเพื่อสมัครเป็นเอเจนต์ขาย
          </Text>
        </div>

        <Form
          form={form}
          layout="vertical"
          onFinish={handleSubmit}
          size="large"
        >
          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="firstName"
                label="ชื่อ"
                rules={[
                  { required: true, message: 'กรุณาใส่ชื่อ' },
                  { min: 2, message: 'ชื่อต้องมีอย่างน้อย 2 ตัวอักษร' }
                ]}
              >
                <Input 
                  prefix={<UserOutlined />}
                  placeholder="ชื่อจริง" 
                />
              </Form.Item>
            </Col>
            <Col xs={24} sm={12}>
              <Form.Item
                name="lastName"
                label="นามสกุล"
                rules={[
                  { required: true, message: 'กรุณาใส่นามสกุล' },
                  { min: 2, message: 'นามสกุลต้องมีอย่างน้อย 2 ตัวอักษร' }
                ]}
              >
                <Input 
                  prefix={<UserOutlined />}
                  placeholder="นามสกุล" 
                />
              </Form.Item>
            </Col>
          </Row>

          <Form.Item
            name="email"
            label="อีเมล"
            rules={[
              { required: true, message: 'กรุณาใส่อีเมล' },
              { type: 'email', message: 'รูปแบบอีเมลไม่ถูกต้อง' }
            ]}
          >
            <Input 
              prefix={<MailOutlined />}
              placeholder="example@email.com" 
            />
          </Form.Item>

          <Form.Item
            name="phone"
            label="เบอร์โทร"
            rules={[
              { pattern: /^[0-9-]+$/, message: 'เบอร์โทรควรเป็นตัวเลขและขีดกลางเท่านั้น' },
              { min: 10, message: 'เบอร์โทรต้องมีอย่างน้อย 10 หลัก' }
            ]}
          >
            <Input 
              prefix={<PhoneOutlined />}
              placeholder="081-234-5678" 
            />
          </Form.Item>

          <Form.Item
            name="idCard"
            label="เลขประจำตัวประชาชน"
            rules={[
              { required: true, message: 'กรุณาใส่เลขประจำตัวประชาชน' },
              { len: 13, message: 'เลขประจำตัวประชาชนต้องมี 13 หลัก' },
              { pattern: /^[0-9]+$/, message: 'เลขประจำตัวประชาชนควรเป็นตัวเลขเท่านั้น' }
            ]}
          >
            <Input 
              prefix={<IdcardOutlined />}
              placeholder="1234567890123" 
              maxLength={13}
            />
          </Form.Item>

          <Form.Item
            name="password"
            label="รหัสผ่าน"
            rules={[
              { required: true, message: 'กรุณาใส่รหัสผ่าน' },
              { min: 6, message: 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร' }
            ]}
          >
            <Input.Password 
              prefix={<LockOutlined />}
              placeholder="รหัสผ่าน" 
            />
          </Form.Item>

          <Form.Item
            name="confirmPassword"
            label="ยืนยันรหัสผ่าน"
            rules={[
              { required: true, message: 'กรุณายืนยันรหัสผ่าน' },
              ({ getFieldValue }) => ({
                validator(_, value) {
                  if (!value || getFieldValue('password') === value) {
                    return Promise.resolve();
                  }
                  return Promise.reject(new Error('รหัสผ่านไม่ตรงกัน'));
                },
              }),
            ]}
          >
            <Input.Password 
              prefix={<LockOutlined />}
              placeholder="ยืนยันรหัสผ่าน" 
            />
          </Form.Item>

          <Form.Item style={{ marginBottom: '16px' }}>
            <Button 
              type="primary" 
              htmlType="submit" 
              loading={loading}
              block
              size="large"
              style={{ height: '48px', fontSize: '16px' }}
            >
              สมัครเป็นเอเจนต์
            </Button>
          </Form.Item>

          <div style={{ textAlign: 'center' }}>
            <Text type="secondary">
              มีบัญชีแล้ว? 
            </Text>
            <Link to="/login" style={{ marginLeft: '8px' }}>
              เข้าสู่ระบบ
            </Link>
          </div>
        </Form>
      </Card>
    </div>
  );
};

export default AgentRegister;