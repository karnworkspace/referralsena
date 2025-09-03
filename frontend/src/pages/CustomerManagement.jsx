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
  IdcardOutlined,
  HomeOutlined,
  TeamOutlined
} from '@ant-design/icons';
import {
  fetchCustomers,
  createCustomer,
  updateCustomer,
  deleteCustomer,
  fetchAgentsList,
  setFilters,
  setPagination,
  clearError
} from '../store/customersSlice';

const { Title } = Typography;
const { Option } = Select;
const { TextArea } = Input;

const CustomerManagement = () => {
  const dispatch = useDispatch();
  const { 
    customers, 
    agentsList,
    loading, 
    agentsLoading,
    error, 
    pagination, 
    filters 
  } = useSelector((state) => state.customers);

  const [isModalVisible, setIsModalVisible] = useState(false);
  const [editingCustomer, setEditingCustomer] = useState(null);
  const [form] = Form.useForm();

  // Load customers and agents on component mount
  useEffect(() => {
    dispatch(fetchCustomers({
      page: pagination.current,
      limit: pagination.pageSize,
      ...filters
    }));
    console.log('=== Dispatching fetchAgentsList ===');
    dispatch(fetchAgentsList());
  }, [dispatch, pagination.current, pagination.pageSize, filters]);

  // Debug agentsList
  useEffect(() => {
    console.log('=== CustomerManagement Debug ===');
    console.log('agentsList:', agentsList);
    console.log('agentsLoading:', agentsLoading);
    console.log('error:', error);
  }, [agentsList, agentsLoading, error]);

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
      title: 'รหัสลูกค้า',
      dataIndex: 'customerCode',
      key: 'customerCode',
      width: 120,
      render: (text) => <Tag color="green">{text}</Tag>
    },
    {
      title: 'ชื่อ-นามสกุล',
      key: 'fullName',
      width: 180,
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
      width: 130,
      render: (text) => text ? (
        <Space>
          <PhoneOutlined />
          <span>{text}</span>
        </Space>
      ) : '-'
    },
    {
      title: 'เอเจนต์',
      key: 'agent',
      width: 150,
      render: (_, record) => record.agent ? (
        <Space>
          <TeamOutlined />
          <span>{`${record.agent.agentCode} - ${record.agent.firstName}`}</span>
        </Space>
      ) : '-'
    },
    {
      title: 'ที่อยู่',
      dataIndex: 'address',
      key: 'address',
      width: 200,
      render: (text) => text ? (
        <Tooltip title={text}>
          <div style={{ 
            maxWidth: '180px', 
            overflow: 'hidden', 
            textOverflow: 'ellipsis',
            whiteSpace: 'nowrap'
          }}>
            <HomeOutlined style={{ marginRight: '4px' }} />
            {text}
          </div>
        </Tooltip>
      ) : '-'
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
              description="คุณแน่ใจหรือไม่ที่จะลบลูกค้านี้?"
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

  // Handle agent filter
  const handleAgentFilter = (value) => {
    dispatch(setFilters({ agentId: value }));
    dispatch(setPagination({ current: 1 }));
  };

  // Handle table change (pagination)
  const handleTableChange = (pagination) => {
    dispatch(setPagination({
      current: pagination.current,
      pageSize: pagination.pageSize
    }));
  };

  // Handle create new customer
  const handleCreate = () => {
    setEditingCustomer(null);
    setIsModalVisible(true);
    form.resetFields();
  };

  // Handle edit customer
  const handleEdit = (customer) => {
    setEditingCustomer(customer);
    setIsModalVisible(true);
    form.setFieldsValue({
      customerCode: customer.customerCode,
      firstName: customer.firstName,
      lastName: customer.lastName,
      email: customer.email,
      phone: customer.phone,
      idCard: customer.idCard,
      address: customer.address,
      agentId: customer.agentId,
      status: customer.status,
      registrationDate: customer.registrationDate
    });
  };

  // Handle delete customer
  const handleDelete = async (id) => {
    try {
      await dispatch(deleteCustomer(id)).unwrap();
      notification.success({
        message: 'สำเร็จ',
        description: 'ลบลูกค้าสำเร็จ',
      });
    } catch (error) {
      notification.error({
        message: 'เกิดข้อผิดพลาด',
        description: error || 'ไม่สามารถลบลูกค้าได้',
      });
    }
  };

  // Handle form submit
  const handleSubmit = async (values) => {
    try {
      if (editingCustomer) {
        // Update existing customer
        await dispatch(updateCustomer({
          id: editingCustomer.id,
          customerData: values
        })).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'อัพเดทข้อมูลลูกค้าสำเร็จ',
        });
      } else {
        // Create new customer
        await dispatch(createCustomer(values)).unwrap();
        notification.success({
          message: 'สำเร็จ',
          description: 'เพิ่มลูกค้าสำเร็จ',
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
    setEditingCustomer(null);
  };

  return (
    <div style={{ padding: '24px' }}>
      <Card>
        <div style={{ marginBottom: '16px' }}>
          <Row justify="space-between" align="middle">
            <Col>
              <Title level={3} style={{ margin: 0 }}>
                <UserOutlined style={{ marginRight: '8px' }} />
                จัดการลูกค้า
              </Title>
            </Col>
            <Col>
              <Button
                type="primary"
                icon={<PlusOutlined />}
                onClick={handleCreate}
              >
                เพิ่มลูกค้าใหม่
              </Button>
            </Col>
          </Row>
        </div>

        {/* Filters */}
        <Row gutter={16} style={{ marginBottom: '16px' }}>
          <Col xs={24} sm={12} md={8}>
            <Input.Search
              placeholder="ค้นหาด้วยชื่อ, รหัสลูกค้า, อีเมล, หรือเบอร์โทร"
              allowClear
              enterButton={<SearchOutlined />}
              onSearch={handleSearch}
              defaultValue={filters.search}
            />
          </Col>
          <Col xs={24} sm={6} md={4}>
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
          <Col xs={24} sm={6} md={6}>
            <Select
              style={{ width: '100%' }}
              placeholder="กรองตามเอเจนต์"
              value={filters.agentId}
              onChange={handleAgentFilter}
              loading={agentsLoading}
            >
              <Option value="all">เอเจนต์ทั้งหมด</Option>
              {agentsList.map(agent => (
                <Option key={agent.id} value={agent.id.toString()}>
                  {agent.fullName}
                </Option>
              ))}
            </Select>
          </Col>
        </Row>

        {/* Table */}
        <Table
          columns={columns}
          dataSource={customers}
          rowKey="id"
          loading={loading}
          scroll={{ x: 1400 }}
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

      {/* Customer Form Modal */}
      <Modal
        title={editingCustomer ? 'แก้ไขข้อมูลลูกค้า' : 'เพิ่มลูกค้าใหม่'}
        open={isModalVisible}
        onCancel={handleCancel}
        footer={null}
        width={700}
      >
        <Form
          form={form}
          layout="vertical"
          onFinish={handleSubmit}
        >
          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="customerCode"
                label="รหัสลูกค้า"
                rules={[
                  { required: true, message: 'กรุณาใส่รหัสลูกค้า' },
                  { pattern: /^[A-Z0-9]+$/, message: 'รหัสลูกค้าควรเป็นตัวอักษรพิมพ์ใหญ่และตัวเลขเท่านั้น' }
                ]}
              >
                <Input 
                  placeholder="เช่น CU001" 
                  disabled={!!editingCustomer}
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
              disabled={!!editingCustomer}
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
                  disabled={!!editingCustomer}
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
              disabled={!!editingCustomer}
            />
          </Form.Item>

          <Form.Item
            name="agentId"
            label="เอเจนต์ที่รับผิดชอบ"
            rules={[{ required: true, message: 'กรุณาเลือกเอเจนต์' }]}
          >
            <Select 
              placeholder="เลือกเอเจนต์"
              loading={agentsLoading}
              showSearch
              optionFilterProp="children"
              filterOption={(input, option) =>
                option.children.toLowerCase().indexOf(input.toLowerCase()) >= 0
              }
            >
              {agentsList.map(agent => (
                <Option key={agent.id} value={agent.id}>
                  {agent.fullName}
                </Option>
              ))}
            </Select>
          </Form.Item>

          <Form.Item
            name="address"
            label="ที่อยู่"
          >
            <TextArea 
              rows={3}
              placeholder="ที่อยู่สำหรับติดต่อ"
            />
          </Form.Item>

          <Form.Item style={{ marginBottom: 0, textAlign: 'right' }}>
            <Space>
              <Button onClick={handleCancel}>
                ยกเลิก
              </Button>
              <Button type="primary" htmlType="submit" loading={loading}>
                {editingCustomer ? 'อัพเดท' : 'เพิ่ม'}
              </Button>
            </Space>
          </Form.Item>
        </Form>
      </Modal>
    </div>
  );
};

export default CustomerManagement;