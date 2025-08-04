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
  UserOutlined,
  MailOutlined,
  PhoneOutlined,
  IdcardOutlined
} from '@ant-design/icons';
import {
  fetchAgents,
  createAgent,
  updateAgent,
  deleteAgent,
  setFilters,
  setPagination,
  clearError
} from '../store/agentsSlice';

const { Title } = Typography;
const { Option } = Select;

const AgentManagement = () => {
  const dispatch = useDispatch();
  const { 
    agents, 
    loading, 
    error, 
    pagination, 
    filters 
  } = useSelector((state) => state.agents);

  const [isModalVisible, setIsModalVisible] = useState(false);
  const [editingAgent, setEditingAgent] = useState(null);
  const [form] = Form.useForm();

  // Load agents on component mount
  useEffect(() => {
    dispatch(fetchAgents({
      page: pagination.current,
      limit: pagination.pageSize,
      ...filters
    }));
  }, [dispatch, pagination.current, pagination.pageSize, filters]);

  // Handle error notifications
  useEffect(() => {
    if (error) {
      notification.error({
        message: 'เกิดข้อผิดพลาด',
        description: error,
      });
      dispatch(clearError());
    }
  }, [error, dispatch]);

  // Table columns
  const columns = [
    {
      title: 'รหัสเอเจนต์',
      dataIndex: 'agentCode',
      key: 'agentCode',
      width: 120,
      render: (text) => <Tag color="blue">{text}</Tag>
    },
    {
      title: 'ชื่อ-นามสกุล',
      key: 'fullName',
      width: 200,
      render: (_, record) => (
        <Space>
          <UserOutlined />
          <span>{`${record.firstName} ${record.lastName}`}</span>
        </Space>
      )
    },
    {
      title: 'อีเมล',
      dataIndex: 'email',
      key: 'email',
      width: 200,
      render: (text) => (
        <Space>
          <MailOutlined />
          <span>{text}</span>
        </Space>
      )
    },
    {
      title: 'เบอร์โทร',
      dataIndex: 'phone',
      key: 'phone',
      width: 150,
      render: (text) => text ? (
        <Space>
          <PhoneOutlined />
          <span>{text}</span>
        </Space>
      ) : '-'
    },
    {
      title: 'เลขประจำตัว',
      dataIndex: 'idCard',
      key: 'idCard',
      width: 150,
      render: (text) => (
        <Space>
          <IdcardOutlined />
          <span>{text}</span>
        </Space>
      )
    },
    {
      title: 'สถานะ',
      dataIndex: 'status',
      key: 'status',
      width: 100,
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
      width: 130,
      render: (date) => new Date(date).toLocaleDateString('th-TH')
    },
    {
      title: 'การจัดการ',
      key: 'actions',
      width: 120,
      fixed: 'right',
      render: (_, record) => (
        <Space>
          <Tooltip title="แก้ไข">
            <Button
              type="text"
              icon={<EditOutlined />}
              onClick={() => handleEdit(record)}
            />
          </Tooltip>
          <Tooltip title="ลบ">
            <Popconfirm
              title="ยืนยันการลบ"
              description="คุณแน่ใจหรือไม่ที่จะลบเอเจนต์นี้?"
              onConfirm={() => handleDelete(record.id)}
              okText="ยืนยัน"
              cancelText="ยกเลิก"
            >
              <Button
                type="text"
                danger
                icon={<DeleteOutlined />}
              />
            </Popconfirm>
          </Tooltip>
        </Space>
      )
    }
  ];

  // Handle search
  const handleSearch = (value) => {
    dispatch(setFilters({ search: value }));
    dispatch(setPagination({ current: 1 }));
  };

  // Handle status filter
  const handleStatusFilter = (value) => {
    dispatch(setFilters({ status: value }));
    dispatch(setPagination({ current: 1 }));
  };

  // Handle table change (pagination)
  const handleTableChange = (pagination) => {
    dispatch(setPagination({
      current: pagination.current,
      pageSize: pagination.pageSize
    }));
  };

  // Handle create new agent
  const handleCreate = () => {
    setEditingAgent(null);
    setIsModalVisible(true);
    form.resetFields();
  };

  // Handle edit agent
  const handleEdit = (agent) => {
    setEditingAgent(agent);
    setIsModalVisible(true);
    form.setFieldsValue({
      agentCode: agent.agentCode,
      firstName: agent.firstName,
      lastName: agent.lastName,
      email: agent.email,
      phone: agent.phone,
      idCard: agent.idCard,
      status: agent.status,
      registrationDate: agent.registrationDate
    });
  };

  // Handle delete agent
  const handleDelete = async (id) => {
    try {
      await dispatch(deleteAgent(id)).unwrap();
      notification.success({
        message: 'สำเร็จ',
        description: 'ลบเอเจนต์สำเร็จ',
      });
    } catch (error) {
      notification.error({
        message: 'เกิดข้อผิดพลาด',
        description: error || 'ไม่สามารถลบเอเจนต์ได้',
      });
    }
  };

  // Handle form submit
  const handleSubmit = async (values) => {
    try {
      if (editingAgent) {
        // Update existing agent
        await dispatch(updateAgent({
          id: editingAgent.id,
          agentData: values
        })).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'อัพเดทข้อมูลเอเจนต์สำเร็จ',
        });
      } else {
        // Create new agent
        await dispatch(createAgent(values)).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'เพิ่มเอเจนต์สำเร็จ',
        });
      }
      setIsModalVisible(false);
      form.resetFields();
    } catch (error) {
      notification.error({
        message: 'เกิดข้อผิดพลาด',
        description: error || 'ไม่สามารถบันทึกข้อมูลได้',
      });
    }
  };

  // Handle modal cancel
  const handleCancel = () => {
    setIsModalVisible(false);
    form.resetFields();
    setEditingAgent(null);
  };

  return (
    <div style={{ padding: '24px' }}>
      <Card>
        <div style={{ marginBottom: '16px' }}>
          <Row justify="space-between" align="middle">
            <Col>
              <Title level={3} style={{ margin: 0 }}>
                <UserOutlined style={{ marginRight: '8px' }} />
                จัดการเอเจนต์
              </Title>
            </Col>
            <Col>
              <Button
                type="primary"
                icon={<PlusOutlined />}
                onClick={handleCreate}
              >
                เพิ่มเอเจนต์ใหม่
              </Button>
            </Col>
          </Row>
        </div>

        {/* Filters */}
        <Row gutter={16} style={{ marginBottom: '16px' }}>
          <Col xs={24} sm={12} md={8}>
            <Input.Search
              placeholder="ค้นหาด้วยชื่อ, รหัสเอเจนต์, หรืออีเมล"
              allowClear
              enterButton={<SearchOutlined />}
              onSearch={handleSearch}
              defaultValue={filters.search}
            />
          </Col>
          <Col xs={24} sm={12} md={6}>
            <Select
              style={{ width: '100%' }}
              placeholder="กรองตามสถานะ"
              value={filters.status}
              onChange={handleStatusFilter}
            >
              <Option value="all">ทั้งหมด</Option>
              <Option value="active">ใช้งาน</Option>
              <Option value="inactive">ไม่ใช้งาน</Option>
            </Select>
          </Col>
        </Row>

        {/* Table */}
        <Table
          columns={columns}
          dataSource={agents}
          rowKey="id"
          loading={loading}
          scroll={{ x: 1200 }}
          pagination={{
            current: pagination.current,
            pageSize: pagination.pageSize,
            total: pagination.total,
            showSizeChanger: true,
            showQuickJumper: true,
            showTotal: (total, range) =>
              `${range[0]}-${range[1]} จาก ${total} รายการ`,
            pageSizeOptions: ['10', '20', '50', '100']
          }}
          onChange={handleTableChange}
        />
      </Card>

      {/* Agent Form Modal */}
      <Modal
        title={editingAgent ? 'แก้ไขข้อมูลเอเจนต์' : 'เพิ่มเอเจนต์ใหม่'}
        open={isModalVisible}
        onCancel={handleCancel}
        footer={null}
        width={600}
      >
        <Form
          form={form}
          layout="vertical"
          onFinish={handleSubmit}
        >
          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="agentCode"
                label="รหัสเอเจนต์"
                rules={[
                  { required: true, message: 'กรุณาใส่รหัสเอเจนต์' },
                  { pattern: /^[A-Z0-9]+$/, message: 'รหัสเอเจนต์ควรเป็นตัวอักษรพิมพ์ใหญ่และตัวเลขเท่านั้น' }
                ]}
              >
                <Input 
                  placeholder="เช่น AG001" 
                  disabled={!!editingAgent}
                />
              </Form.Item>
            </Col>
            <Col xs={24} sm={12}>
              <Form.Item
                name="status"
                label="สถานะ"
                rules={[{ required: true, message: 'กรุณาเลือกสถานะ' }]}
              >
                <Select placeholder="เลือกสถานะ">
                  <Option value="active">ใช้งาน</Option>
                  <Option value="inactive">ไม่ใช้งาน</Option>
                </Select>
              </Form.Item>
            </Col>
          </Row>

          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="firstName"
                label="ชื่อ"
                rules={[{ required: true, message: 'กรุณาใส่ชื่อ' }]}
              >
                <Input placeholder="ชื่อจริง" />
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
              { required: true, message: 'กรุณาใส่อีเมล' },
              { type: 'email', message: 'รูปแบบอีเมลไม่ถูกต้อง' }
            ]}
          >
            <Input 
              placeholder="example@email.com" 
              disabled={!!editingAgent}
            />
          </Form.Item>

          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="phone"
                label="เบอร์โทร"
                rules={[
                  { pattern: /^[0-9-]+$/, message: 'เบอร์โทรควรเป็นตัวเลขและขีดกลางเท่านั้น' }
                ]}
              >
                <Input placeholder="081-234-5678" />
              </Form.Item>
            </Col>
            <Col xs={24} sm={12}>
              <Form.Item
                name="registrationDate"
                label="วันที่ลงทะเบียน"
                rules={[{ required: true, message: 'กรุณาใส่วันที่ลงทะเบียน' }]}
              >
                <Input 
                  type="date" 
                  disabled={!!editingAgent}
                />
              </Form.Item>
            </Col>
          </Row>

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
              placeholder="1234567890123" 
              maxLength={13}
              disabled={!!editingAgent}
            />
          </Form.Item>

          <Form.Item style={{ marginBottom: 0, textAlign: 'right' }}>
            <Space>
              <Button onClick={handleCancel}>
                ยกเลิก
              </Button>
              <Button type="primary" htmlType="submit" loading={loading}>
                {editingAgent ? 'อัพเดท' : 'เพิ่ม'}
              </Button>
            </Space>
          </Form.Item>
        </Form>
      </Modal>
    </div>
  );
};

export default AgentManagement;