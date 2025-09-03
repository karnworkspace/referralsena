import React, { useState } from 'react';
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
  Badge
} from 'antd';
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  UserOutlined,
  LogoutOutlined,
  DashboardOutlined,
  TeamOutlined,
  UsergroupAddOutlined,
  ProjectOutlined,
  BarChartOutlined,
  SettingOutlined,
  BellOutlined
} from '@ant-design/icons';
import { useDispatch, useSelector } from 'react-redux';
import { logoutUser } from '../store/authSlice';
import AgentManagement from './AgentManagement';
import CustomerManagement from './CustomerManagement';

const { Header, Sider, Content } = Layout;
const { Title, Text } = Typography;

const Dashboard = () => {
  const dispatch = useDispatch();
  const { user } = useSelector((state) => state.auth);
  const [collapsed, setCollapsed] = useState(false);
  const [selectedMenu, setSelectedMenu] = useState('dashboard');

  const handleLogout = () => {
    dispatch(logoutUser());
  };

  const userMenuItems = [
    {
      key: 'profile',
      icon: <UserOutlined />,
      label: 'โปรไฟล์',
    },
    {
      key: 'settings',
      icon: <SettingOutlined />,
      label: 'ตั้งค่า',
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
      key: 'agents',
      icon: <TeamOutlined />,
      label: 'จัดการเอเจนต์',
    },
    {
      key: 'customers',
      icon: <UsergroupAddOutlined />,
      label: 'จัดการลูกค้า',
    },
    {
      key: 'projects',
      icon: <ProjectOutlined />,
      label: 'จัดการโครงการ',
    },
    {
      key: 'reports',
      icon: <BarChartOutlined />,
      label: 'รายงาน',
    },
  ];

  const renderContent = () => {
    switch (selectedMenu) {
      case 'dashboard':
        return (
          <div>
            <Row gutter={[16, 16]} style={{ marginBottom: '24px' }}>
              <Col xs={24} sm={12} lg={6}>
                <Card>
                  <Statistic
                    title="เอเจนต์ทั้งหมด"
                    value={4}
                    valueStyle={{ color: '#3f8600' }}
                  />
                </Card>
              </Col>
              <Col xs={24} sm={12} lg={6}>
                <Card>
                  <Statistic
                    title="เอเจนต์รออนุมัติ"
                    value={1}
                    valueStyle={{ color: '#fa8c16' }}
                  />
                  <div style={{ marginTop: '8px' }}>
                    <Button 
                      type="link" 
                      size="small"
                      onClick={() => setSelectedMenu('agents')}
                    >
                      ดูรายละเอียด →
                    </Button>
                  </div>
                </Card>
              </Col>
              <Col xs={24} sm={12} lg={6}>
                <Card>
                  <Statistic
                    title="ลูกค้าใหม่"
                    value={5}
                    valueStyle={{ color: '#1890ff' }}
                  />
                </Card>
              </Col>
              <Col xs={24} sm={12} lg={6}>
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
            
            <Card title="กิจกรรมล่าสุด" style={{ marginBottom: '24px' }}>
              <Text type="secondary">ยังไม่มีข้อมูลกิจกรรม</Text>
            </Card>
          </div>
        );
      case 'agents':
        return <AgentManagement />;
      case 'customers':
        return <CustomerManagement />;
      case 'projects':
        return (
          <Card title="จัดการโครงการ">
            <Text type="secondary">หน้าจัดการโครงการ - กำลังพัฒนา</Text>
          </Card>
        );
      case 'reports':
        return (
          <Card title="รายงาน">
            <Text type="secondary">หน้ารายงาน - กำลังพัฒนา</Text>
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
              SENA Agent
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
            <Badge count={5}>
              <Button type="text" icon={<BellOutlined />} size="large" />
            </Badge>
            
            <Dropdown menu={{ items: userMenuItems }} placement="bottomRight">
              <Space style={{ cursor: 'pointer' }}>
                <Avatar icon={<UserOutlined />} />
                <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'flex-start' }}>
                  <Text strong>{user?.email}</Text>
                  <Text type="secondary" style={{ fontSize: '12px' }}>
                    {user?.role === 'admin' ? 'ผู้ดูแลระบบ' : 'เอเจนต์'}
                  </Text>
                </div>
              </Space>
            </Dropdown>
          </Space>
        </Header>
        
        <Content style={{ 
          margin: (selectedMenu === 'agents' || selectedMenu === 'customers') ? '0' : '24px', 
          padding: (selectedMenu === 'agents' || selectedMenu === 'customers') ? '0' : '24px',
          background: (selectedMenu === 'agents' || selectedMenu === 'customers') ? '#f0f2f5' : '#fff',
          borderRadius: (selectedMenu === 'agents' || selectedMenu === 'customers') ? '0' : '8px',
          minHeight: 'calc(100vh - 112px)'
        }}>
          {renderContent()}
        </Content>
      </Layout>
    </Layout>
  );
};

export default Dashboard;