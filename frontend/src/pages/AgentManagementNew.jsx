import React, { useState, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import {
  Card,
  Table,
  Button,
  Space,
  Modal,
  Form,
  Input,
  Select,
  Row,
  Col,
  Typography,
  Tag,
  notification,
  Popconfirm,
  Tooltip
} from 'antd';
import {
  PlusOutlined,
  EditOutlined,
  DeleteOutlined,
  SearchOutlined,
  MailOutlined,
  PhoneOutlined,
  UserOutlined,
  IdcardOutlined,
  CheckCircleOutlined,
  ClockCircleOutlined
} from '@ant-design/icons';
import {
  fetchAgents,
  createAgent,
  updateAgent,
  deleteAgent,
  setFilters
} from '../store/agentsSlice';

const { Title } = Typography;

const AgentManagementNew = () => {
  const dispatch = useDispatch();
  const { agents, loading, pagination, filters } = useSelector((state) => state.agents);

  const [statusFilter, setStatusFilter] = useState('all');
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [editingAgent, setEditingAgent] = useState(null);
  const [form] = Form.useForm();

  useEffect(() => {
    dispatch(fetchAgents({
      page: pagination.current,
      limit: pagination.pageSize,
      ...filters
    }));
  }, [dispatch, pagination.current, pagination.pageSize, filters]);

  const handleSearch = (value) => {
    dispatch(setFilters({ search: value }));
  };

  const handleStatusFilter = (status) => {
    setStatusFilter(status);
    dispatch(setFilters({ status }));
  };

  const handleAdd = () => {
    setEditingAgent(null);
    setIsModalVisible(true);
    form.resetFields();
  };

  const handleEdit = (agent) => {
    setEditingAgent(agent);
    setIsModalVisible(true);
    form.setFieldsValue({
      agentCode: agent.agentCode,
      firstName: agent.firstName,
      lastName: agent.lastName,
      email: agent.User?.email || agent.email,
      phone: agent.phone,
      idCard: agent.idCard,
      status: agent.status,
    });
  };

  const handleSubmit = async (values) => {
    try {
      if (editingAgent) {
        await dispatch(updateAgent({
          id: editingAgent.id,
          agentData: values
        })).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'อัพเดทข้อมูลเอเจนต์สำเร็จ',
        });
      } else {
        const agentData = {
          ...values,
          password: values.idCard
        };
        await dispatch(createAgent(agentData)).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'เพิ่มเอเจนต์สำเร็จ',
        });
      }
      setIsModalVisible(false);
      form.resetFields();
    } catch (error) {
      const errorMessage = error || 'ไม่สามารถบันทึกข้อมูลได้';

      let alertMessage = 'เกิดข้อผิดพลาด';
      let alertDescription = errorMessage;

      if (errorMessage.includes('อีเมลนี้ถูกใช้แล้ว')) {
        alertMessage = '🚫 อีเมลซ้ำในระบบ';
        alertDescription = 'อีเมลนี้ถูกใช้งานแล้ว กรุณาใช้อีเมลอื่น';
      } else if (errorMessage.includes('เลขบัตรประชาชนนี้ถูกใช้แล้ว')) {
        alertMessage = '🚫 เลขบัตรประชาชนซ้ำในระบบ';
        alertDescription = 'เลขบัตรประชาชนนี้ถูกใช้งานแล้ว กรุณาตรวจสอบข้อมูล';
      } else if (errorMessage.includes('เบอร์โทรศัพท์นี้ถูกใช้แล้ว')) {
        alertMessage = '🚫 เบอร์โทรศัพท์ซ้ำในระบบ';
        alertDescription = 'เบอร์โทรศัพท์นี้ถูกใช้งานแล้ว กรุณาใช้เบอร์อื่น';
      } else if (errorMessage.includes('รหัสเอเจนต์นี้มีอยู่ในระบบแล้ว')) {
        alertMessage = '🚫 รหัสเอเจนต์ซ้ำในระบบ';
        alertDescription = 'รหัสเอเจนต์นี้ถูกใช้งานแล้ว กรุณาใช้รหัสอื่น';
      }

      notification.error({
        message: alertMessage,
        description: alertDescription,
        duration: 6,
        placement: 'topRight'
      });
    }
  };

  const handleDelete = async (id) => {
    try {
      await dispatch(deleteAgent(id)).unwrap();
      notification.success({
        message: 'สำเร็จ',
        description: 'ลบเอเจนต์สำเร็จ',
      });
    } catch (error) {
      notification.error({
        message: 'ไม่สามารถลบเอเจนต์ได้',
        description: error || 'เกิดข้อผิดพลาดในการลบเอเจนต์',
      });
    }
  };

  const getStatusTag = (status) => {
    switch (status) {
      case 'active':
        return <Tag icon={<CheckCircleOutlined />} color="green">ใช้งาน</Tag>;
      case 'inactive':
        return <Tag icon={<ClockCircleOutlined />} color="orange">รออนุมัติ</Tag>;
      default:
        return <Tag color="default">{status}</Tag>;
    }
  };

  const columns = [
    {
      title: 'รหัสเอเจนต์',
      dataIndex: 'agentCode',
      key: 'agentCode',
      width: 120,
      render: (text, record) => text || `#${record.id}`
    },
    {
      title: 'ชื่อ-นามสกุล',
      key: 'name',
      width: 200,
      render: (_, record) => (
        <Space>
          <UserOutlined />
          <span>{record.firstName} {record.lastName}</span>
        </Space>
      )
    },
    {
      title: 'อีเมล',
      key: 'email',
      width: 200,
      render: (_, record) => {
        const email = record.User?.email || record.email;
        return email ? (
          <Space>
            <MailOutlined />
            <span>{email}</span>
          </Space>
        ) : '-';
      }
    },
    {
      title: 'เบอร์โทร',
      dataIndex: 'phone',
      key: 'phone',
      width: 140,
      render: (text) => text ? (
        <Space>
          <PhoneOutlined />
          <span>{text}</span>
        </Space>
      ) : '-'
    },
    {
      title: 'สถานะ',
      dataIndex: 'status',
      key: 'status',
      width: 120,
      render: (status) => getStatusTag(status)
    },
    {
      title: 'จัดการ',
      key: 'action',
      width: 120,
      render: (_, record) => (
        <Space size="middle">
          <Tooltip title="แก้ไข">
            <Button
              type="link"
              icon={<EditOutlined />}
              onClick={() => handleEdit(record)}
              size="small"
            >
              แก้ไข
            </Button>
          </Tooltip>
          <Popconfirm
            title="ลบเอเจนต์"
            description="คุณแน่ใจหรือไม่ที่จะลบเอเจนต์นี้?"
            onConfirm={() => handleDelete(record.id)}
            okText="ใช่"
            cancelText="ไม่"
          >
            <Button type="link" danger icon={<DeleteOutlined />} size="small">
              ลบ
            </Button>
          </Popconfirm>
        </Space>
      ),
    },
  ];

  return (
    <div style={{ backgroundColor: '#f0f2f5', minHeight: '100vh', padding: 0 }}>
      {/* Header */}
      <Card
        style={{
          marginBottom: 24,
          borderRadius: 0,
          boxShadow: '0 1px 4px rgba(0,21,41,.08)'
        }}
        styles={{ body: { padding: '24px' } }}
      >
        <Row justify="space-between" align="middle">
          <Col>
            <Title level={2} style={{ margin: 0 }}>
              จัดการเอเจนต์
            </Title>
          </Col>
          <Col>
            <Button
              type="primary"
              icon={<PlusOutlined />}
              onClick={handleAdd}
            >
              เพิ่มเอเจนต์
            </Button>
          </Col>
        </Row>
      </Card>

      {/* Search and Filters */}
      <Card
        style={{
          margin: '0 24px 24px 24px',
          borderRadius: 8,
          boxShadow: '0 1px 4px rgba(0,21,41,.08)'
        }}
        styles={{ body: { padding: '24px' } }}
      >
        <Row gutter={[16, 16]}>
          <Col xs={24} sm={24} md={12} lg={8}>
            <Input.Search
              placeholder="ค้นหาเอเจนต์ด้วยชื่อหรือรหัส..."
              allowClear
              enterButton={<SearchOutlined />}
              size="middle"
              onSearch={handleSearch}
              style={{ width: '100%' }}
            />
          </Col>
          <Col xs={24} sm={24} md={12} lg={16}>
            <Space wrap>
              <Button
                type={statusFilter === 'all' ? 'primary' : 'default'}
                onClick={() => handleStatusFilter('all')}
              >
                ทั้งหมด
              </Button>
              <Button
                type={statusFilter === 'active' ? 'primary' : 'default'}
                onClick={() => handleStatusFilter('active')}
              >
                ใช้งาน
              </Button>
              <Button
                type={statusFilter === 'inactive' ? 'primary' : 'default'}
                onClick={() => handleStatusFilter('inactive')}
              >
                รออนุมัติ
              </Button>
            </Space>
          </Col>
        </Row>
      </Card>

      {/* Table */}
      <Card
        style={{
          margin: '0 24px',
          borderRadius: 8,
          boxShadow: '0 1px 4px rgba(0,21,41,.08)'
        }}
        styles={{ body: { padding: 0 } }}
      >
        <Table
          columns={columns}
          dataSource={agents}
          rowKey="id"
          loading={loading}
          pagination={{
            current: pagination.current,
            pageSize: pagination.pageSize,
            total: pagination.total,
            showSizeChanger: true,
            showQuickJumper: true,
            showTotal: (total, range) =>
              `${range[0]}-${range[1]} จาก ${total} รายการ`,
          }}
          scroll={{ x: 800 }}
        />
      </Card>

      {/* Modal */}
      <Modal
        title={editingAgent ? 'แก้ไขข้อมูลเอเจนต์' : 'เพิ่มเอเจนต์ใหม่'}
        open={isModalVisible}
        onCancel={() => {
          setIsModalVisible(false);
          form.resetFields();
        }}
        footer={null}
        width={600}
      >
        <Form
          form={form}
          layout="vertical"
          onFinish={handleSubmit}
          autoComplete="off"
        >
          <Form.Item
            name="agentCode"
            label="รหัสเอเจนต์"
            rules={[
              { pattern: /^AG\d{3}$/, message: 'รหัสเอเจนต์ต้องเป็นรูปแบบ AG001' }
            ]}
          >
            <Input placeholder="AG001" />
          </Form.Item>

          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="firstName"
                label="ชื่อ"
                rules={[{ required: true, message: 'กรุณาใส่ชื่อ' }]}
              >
                <Input placeholder="ชื่อ" />
              </Form.Item>
            </Col>
            <Col xs={24} sm={12}>
              <Form.Item
                name="lastName"
                label="นามสกุล"
                rules={[{ required: true, message: 'กรุณาใส่นามสกุล' }]}
              >
                <Input placeholder="นามสกุล" />
              </Form.Item>
            </Col>
          </Row>

          <Form.Item
            name="email"
            label="อีเมล"
            rules={[
              { required: !editingAgent, message: 'กรุณาใส่อีเมล' },
              { type: 'email', message: 'รูปแบบอีเมลไม่ถูกต้อง' }
            ]}
          >
            <Input
              placeholder="example@email.com"
              disabled={!!editingAgent}
              prefix={<MailOutlined />}
            />
          </Form.Item>

          <Form.Item
            name="phone"
            label="เบอร์โทรศัพท์"
            rules={[
              { pattern: /^[0-9-]+$/, message: 'เบอร์โทรควรเป็นตัวเลขและขีดกลางเท่านั้น' }
            ]}
          >
            <Input placeholder="081-234-5678" prefix={<PhoneOutlined />} />
          </Form.Item>

          <Form.Item
            name="idCard"
            label="เลขประจำตัวประชาชน"
            extra={!editingAgent ? "หมายเลขนี้จะใช้เป็นรหัสผ่านสำหรับเข้าสู่ระบบ" : undefined}
            rules={[
              { required: true, message: 'กรุณาใส่เลขประจำตัวประชาชน' },
              { len: 13, message: 'เลขประจำตัวประชาชนต้องมี 13 หลัก' },
              { pattern: /^[0-9]+$/, message: 'เลขประจำตัวประชาชนควรเป็นตัวเลขเท่านั้น' }
            ]}
          >
            <Input
              placeholder="1234567890123"
              maxLength={13}
              disabled={!!editingAgent}
              prefix={<IdcardOutlined />}
            />
          </Form.Item>

          <Form.Item
            name="status"
            label="สถานะ"
            rules={[{ required: true, message: 'กรุณาเลือกสถานะ' }]}
          >
            <Select placeholder="เลือกสถานะ">
              <Select.Option value="active">ใช้งาน</Select.Option>
              <Select.Option value="inactive">รออนุมัติ</Select.Option>
            </Select>
          </Form.Item>

          <Form.Item style={{ marginBottom: 0, textAlign: 'right' }}>
            <Space>
              <Button onClick={() => setIsModalVisible(false)}>
                ยกเลิก
              </Button>
              <Button type="primary" htmlType="submit">
                {editingAgent ? 'อัปเดต' : 'เพิ่ม'}
              </Button>
            </Space>
          </Form.Item>
        </Form>
      </Modal>
    </div>
  );
};

export default AgentManagementNew;