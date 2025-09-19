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
  Spin,
  List
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
  BellOutlined,
  ClockCircleOutlined,
  EditOutlined,
  PlusOutlined
} from '@ant-design/icons';
import { useDispatch, useSelector } from 'react-redux';
import { logoutUser } from '../store/authSlice';
import { dashboardAPI } from '../services/api';
import AgentManagementNew from './AgentManagementNew';
import CustomerManagement from './CustomerManagement';
import ProjectManagement from './ProjectManagement';
import StatisticsBarChart from '../components/charts/StatisticsBarChart';
import CustomerStatusPieChart from '../components/charts/CustomerStatusPieChart';
import TrendLineChart from '../components/charts/TrendLineChart';
import PerformanceAreaChart from '../components/charts/PerformanceAreaChart';

const { Header, Sider, Content } = Layout;
const { Title, Text } = Typography;

const Dashboard = () => {
  const dispatch = useDispatch();
  const { user } = useSelector((state) => state.auth);
  const [collapsed, setCollapsed] = useState(false);
  const [selectedMenu, setSelectedMenu] = useState('dashboard');
  const [dashboardStats, setDashboardStats] = useState({
    totalAgents: 0,
    pendingAgents: 0,
    activeAgents: 0,
    totalCustomers: 0,
    newCustomers: 0,
    pendingCustomers: 0
  });
  const [recentActivities, setRecentActivities] = useState([]);
  const [statsLoading, setStatsLoading] = useState(false);
  const [activitiesLoading, setActivitiesLoading] = useState(false);

  const fetchDashboardStats = async () => {
    try {
      setStatsLoading(true);
      const response = await dashboardAPI.getStats();
      console.log('Dashboard API response:', response);

      // API returns nested structure: data.agents.total, data.customers.total
      if (response.data) {
        setDashboardStats({
          totalAgents: response.data.agents.total,
          pendingAgents: response.data.agents.pending,
          activeAgents: response.data.agents.active,
          totalCustomers: response.data.customers.total,
          newCustomers: response.data.customers.new,
          pendingCustomers: 0 // Not in current API
        });
      }
    } catch (error) {
      console.error('Error fetching dashboard stats:', error);
    } finally {
      setStatsLoading(false);
    }
  };

  const fetchRecentActivities = async () => {
    try {
      setActivitiesLoading(true);
      const response = await dashboardAPI.getRecentActivities();
      console.log('Recent activities response:', response);

      if (response.data) {
        setRecentActivities(response.data);
      }
    } catch (error) {
      console.error('Error fetching recent activities:', error);
    } finally {
      setActivitiesLoading(false);
    }
  };

  useEffect(() => {
    if (selectedMenu === 'dashboard') {
      fetchDashboardStats();
      fetchRecentActivities();
    }
  }, [selectedMenu]);

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
            {/* Charts Section - ย้ายมาด้านบนสุด */}
            <Row gutter={[16, 16]} style={{ marginBottom: '24px' }}>
              <Col xs={24} lg={12}>
                <StatisticsBarChart data={dashboardStats} title="สถิติรวม" />
              </Col>
              <Col xs={24} lg={12}>
                <CustomerStatusPieChart data={dashboardStats} title="สัดส่วนสถานะลูกค้า" />
              </Col>
            </Row>

            <Row gutter={[16, 16]} style={{ marginBottom: '24px' }}>
              <Col xs={24} lg={12}>
                <TrendLineChart data={dashboardStats} title="แนวโน้มรายเดือน" />
              </Col>
              <Col xs={24} lg={12}>
                <PerformanceAreaChart data={dashboardStats} title="ผลงานรายสัปดาห์" />
              </Col>
            </Row>

            {/* Statistics Cards */}
            <Spin spinning={statsLoading}>
              <Row gutter={[16, 16]} style={{ marginBottom: '24px' }}>
                <Col xs={24} sm={12} lg={6}>
                  <Card>
                    <Statistic
                      title="เอเจนต์ทั้งหมด"
                      value={dashboardStats.totalAgents}
                      valueStyle={{ color: '#3f8600' }}
                    />
                  </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                  <Card>
                    <Statistic
                      title="เอเจนต์รออนุมัติ"
                      value={dashboardStats.pendingAgents}
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
                      title="เอเจนต์ที่อนุมัติแล้ว"
                      value={dashboardStats.activeAgents}
                      valueStyle={{ color: '#52c41a' }}
                    />
                  </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                  <Card>
                    <Statistic
                      title="ลูกค้าทั้งหมด"
                      value={dashboardStats.totalCustomers}
                      valueStyle={{ color: '#1890ff' }}
                    />
                    <div style={{ marginTop: '8px' }}>
                      <Button
                        type="link"
                        size="small"
                        onClick={() => setSelectedMenu('customers')}
                      >
                        ดูรายละเอียด →
                      </Button>
                    </div>
                  </Card>
                </Col>
              </Row>
            </Spin>

            <Card
              title="กิจกรรมล่าสุด"
              style={{ marginBottom: '24px' }}
              extra={
                <Button
                  type="link"
                  size="small"
                  onClick={() => {
                    fetchRecentActivities();
                  }}
                >
                  รีเฟรช
                </Button>
              }
            >
              <Spin spinning={activitiesLoading}>
                {recentActivities.length > 0 ? (
                  <List
                    itemLayout="horizontal"
                    dataSource={recentActivities}
                    renderItem={(activity) => {
                      const getActivityIcon = (iconType) => {
                        switch (iconType) {
                          case 'user':
                            return activity.action === 'created' ? <PlusOutlined /> : <EditOutlined />;
                          case 'team':
                            return activity.action === 'created' ? <PlusOutlined /> : <EditOutlined />;
                          default:
                            return <ClockCircleOutlined />;
                        }
                      };

                      const getActivityColor = (action) => {
                        return action === 'created' ? '#52c41a' : '#1890ff';
                      };

                      return (
                        <List.Item>
                          <List.Item.Meta
                            avatar={
                              <Avatar
                                icon={getActivityIcon(activity.icon)}
                                style={{
                                  backgroundColor: getActivityColor(activity.action),
                                  color: 'white'
                                }}
                                size="small"
                              />
                            }
                            title={
                              <Text strong style={{ fontSize: '14px' }}>
                                {activity.title}
                              </Text>
                            }
                            description={
                              <div>
                                <Text type="secondary" style={{ fontSize: '13px' }}>
                                  {activity.description}
                                </Text>
                                <br />
                                <Text type="secondary" style={{ fontSize: '12px' }}>
                                  <ClockCircleOutlined style={{ marginRight: '4px' }} />
                                  {new Date(activity.timestamp).toLocaleString('th-TH', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                  })}
                                </Text>
                              </div>
                            }
                          />
                        </List.Item>
                      );
                    }}
                  />
                ) : (
                  <div style={{ textAlign: 'center', padding: '40px 0' }}>
                    <ClockCircleOutlined style={{ fontSize: '48px', color: '#d9d9d9', marginBottom: '16px' }} />
                    <br />
                    <Text type="secondary">ยังไม่มีกิจกรรมล่าสุด</Text>
                    <br />
                    <Text type="secondary" style={{ fontSize: '12px' }}>
                      เมื่อคุณเพิ่มหรือแก้ไขข้อมูลจะแสดงที่นี่
                    </Text>
                  </div>
                )}
              </Spin>
            </Card>
          </div>
        );
      case 'agents':
        return <AgentManagementNew />;
      case 'customers':
        return <CustomerManagement />;
      case 'projects':
        return <ProjectManagement />;
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
          justifyContent: collapsed ? 'center' : 'flex-start',
          gap: collapsed ? 0 : 10
        }}>
          <img 
            src="/sena-logo.png" 
            alt="SENA"
            style={{ width: collapsed ? 28 : 28, height: 28, objectFit: 'contain', borderRadius: 4 }}
          />
          {!collapsed && (
            <Title level={4} style={{ color: 'white', margin: 0 }}>SENA Agent</Title>
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
