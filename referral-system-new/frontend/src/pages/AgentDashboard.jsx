import React, { useState, useEffect } from 'react';
import { 
  Layout, 
  Menu, 
  Button, 
  Avatar, 
  Dropdown, 
  Typography, 
  Card, 
  Row, 
  Col, 
  Statistic,
  Space,
  Badge,
  Table,
  Tag
} from 'antd';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UserOutlined,
  LogoutOutlined,
  DashboardOutlined,
  UsergroupAddOutlined,
  ProfileOutlined,
  BellOutlined,
  TeamOutlined
} from '@ant-design/icons';
import { useDispatch, useSelector } from 'react-redux';
import { logoutUser } from '../store/authSlice';
import { useNavigate } from 'react-router-dom';

const { Header, Sider, Content } = Layout;
const { Title, Text } = Typography;

const AgentDashboard = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const { user } = useSelector((state) => state.auth);
  const [collapsed, setCollapsed] = useState(false);
  const [selectedMenu, setSelectedMenu] = useState('dashboard');

  const handleLogout = () => {
    dispatch(logoutUser());
    navigate('/login');
  };

  const userMenuItems = [
    {
      key: 'profile',
      icon: <UserOutlined />,
      label: 'โปรไฟล์',
    },
    {
      type: 'divider',
    },
    {
      key: 'logout',
      icon: <LogoutOutlined />,
      label: 'ออกจากระบบ',
      danger: true,
      onClick: handleLogout,
    },
  ];

  const menuItems = [
    {
      key: 'dashboard',
      icon: <DashboardOutlined />,
      label: 'แดชบอร์ด',
    },
    {
      key: 'customers',
      icon: <UsergroupAddOutlined />,
      label: 'ลูกค้าของฉัน',
    },
    {
      key: 'profile',
      icon: <ProfileOutlined />,
      label: 'ข้อมูลส่วนตัว',
    },
  ];

  // Mock data for agent's customers
  const myCustomers = [
    {
      key: '1',
      customerCode: 'CU001',
      name: 'นพดล สุขใจ',
      email: 'napadol@example.com',
      phone: '081-111-2222',
      status: 'active',
      registrationDate: '2023-06-01'
    },
    {
      key: '2',
      customerCode: 'CU002', 
      name: 'สมหญิง ใจดี',
      email: 'somying@example.com',
      phone: '082-222-3333',
      status: 'active',
      registrationDate: '2023-06-15'
    }
  ];

  const customerColumns = [
    {
      title: 'รหัสลูกค้า',
      dataIndex: 'customerCode',
      key: 'customerCode',
      render: (text) => <Tag color="green">{text}</Tag>
    },
    {
      title: 'ชื่อ-นามสกุล',
      dataIndex: 'name',
      key: 'name',
    },
    {
      title: 'อีเมล',
      dataIndex: 'email',
      key: 'email',
    },
    {
      title: 'เบอร์โทร',
      dataIndex: 'phone',
      key: 'phone',
    },
    {
      title: 'สถานะ',
      dataIndex: 'status',
      key: 'status',
      render: (status) => (
        <Tag color={status === 'active' ? 'green' : 'red'}>
          {status === 'active' ? 'ใช้งาน' : 'ไม่ใช้งาน'}
        </Tag>
      )
    },
    {
      title: 'วันที่ลงทะเบียน',
      dataIndex: 'registrationDate',
      key: 'registrationDate',
      render: (date) => new Date(date).toLocaleDateString('th-TH')
    }
  ];

  const renderContent = () => {
    switch (selectedMenu) {
      case 'dashboard':
        return (
          <div>
            <Row gutter={[16, 16]} style={{ marginBottom: '24px' }}>
              <Col xs={24} sm={12} lg={8}>
                <Card>
                  <Statistic
                    title="ลูกค้าทั้งหมด"
                    value={myCustomers.length}
                    valueStyle={{ color: '#3f8600' }}
                  />
                </Card>
              </Col>
              <Col xs={24} sm={12} lg={8}>
                <Card>
                  <Statistic
                    title="ลูกค้าใหม่เดือนนี้"
                    value={1}
                    valueStyle={{ color: '#1890ff' }}
                  />
                </Card>
              </Col>
              <Col xs={24} sm={12} lg={8}>
                <Card>
                  <Statistic
                    title="ยอดขายเดือนนี้"
                    value={0}
                    suffix="บาท"
                    valueStyle={{ color: '#cf1322' }}
                  />
                </Card>
              </Col>
            </Row>
            
            <Card title="ลูกค้าล่าสุด" style={{ marginBottom: '24px' }}>
              <Table 
                dataSource={myCustomers} 
                columns={customerColumns}
                pagination={false}
                size="small"
              />
            </Card>
          </div>
        );
      case 'customers':
        return (
          <Card title="ลูกค้าของฉัน">
            <Table 
              dataSource={myCustomers} 
              columns={customerColumns}
              pagination={{
                pageSize: 10,
                showSizeChanger: true,
                showQuickJumper: true,
                showTotal: (total, range) =>
                  `${range[0]}-${range[1]} จาก ${total} รายการ`,
              }}
            />
          </Card>
        );
      case 'profile':
        return (
          <Card title="ข้อมูลส่วนตัว">
            <Row gutter={16}>
              <Col span={12}>
                <Space direction="vertical" size="middle" style={{ width: '100%' }}>
                  <div>
                    <Text strong>รหัสเอเจนต์:</Text>
                    <br />
                    <Text style={{ fontSize: '16px' }}>{user?.agentCode}</Text>
                  </div>
                  <div>
                    <Text strong>ชื่อ-นามสกุล:</Text>
                    <br />
                    <Text style={{ fontSize: '16px' }}>
                      {user?.firstName} {user?.lastName}
                    </Text>
                  </div>
                  <div>
                    <Text strong>อีเมล:</Text>
                    <br />
                    <Text style={{ fontSize: '16px' }}>{user?.email}</Text>
                  </div>
                  <div>
                    <Text strong>สถานะ:</Text>
                    <br />
                    <Tag color="green" style={{ fontSize: '14px' }}>
                      ใช้งาน
                    </Tag>
                  </div>
                </Space>
              </Col>
            </Row>
          </Card>
        );
      default:
        return null;
    }
  };

  return (
    <Layout style={{ minHeight: '100vh' }}>
      <Sider trigger={null} collapsible collapsed={collapsed}>
        <div style={{ 
          height: '64px', 
          padding: '16px', 
          background: 'rgba(255, 255, 255, 0.1)',
          display: 'flex',
          alignItems: 'center',
          justifyContent: collapsed ? 'center' : 'flex-start'
        }}>
          {!collapsed && (
            <Title level={4} style={{ color: 'white', margin: 0 }}>
              <TeamOutlined style={{ marginRight: '8px' }} />
              Agent Portal
            </Title>
          )}
        </div>
        <Menu
          theme="dark"
          mode="inline"
          selectedKeys={[selectedMenu]}
          items={menuItems}
          onSelect={({ key }) => setSelectedMenu(key)}
        />
      </Sider>
      
      <Layout>
        <Header style={{ 
          padding: '0 24px', 
          background: '#fff',
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          boxShadow: '0 1px 4px rgba(0,21,41,.08)'
        }}>
          <Space>
            <Button
              type="text"
              icon={collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}
              onClick={() => setCollapsed(!collapsed)}
              style={{ fontSize: '16px', width: 64, height: 64 }}
            />
          </Space>
          
          <Space size="middle">
            <Badge count={0}>
              <Button type="text" icon={<BellOutlined />} size="large" />
            </Badge>
            
            <Dropdown menu={{ items: userMenuItems }} placement="bottomRight">
              <Space style={{ cursor: 'pointer' }}>
                <Avatar icon={<UserOutlined />} />
                <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
                  <Text strong>{user?.firstName} {user?.lastName}</Text>
                  <Text type="secondary" style={{ fontSize: '12px' }}>
                    {user?.agentCode} - เอเจนต์
                  </Text>
                </div>
              </Space>
            </Dropdown>
          </Space>
        </Header>
        
        <Content style={{ 
          margin: '24px', 
          padding: '24px',
          background: '#fff',
          borderRadius: '8px',
          minHeight: 'calc(100vh - 112px)'
        }}>
          {renderContent()}
        </Content>
      </Layout>
    </Layout>
  );
};

export default AgentDashboard;