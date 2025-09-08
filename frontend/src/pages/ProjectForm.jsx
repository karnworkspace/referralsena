import React from 'react';
import {
  Card,
  Button,
  Form,
  Input,
  Row,
  Col,
  Typography,
  Select
} from 'antd';
import { ArrowLeftOutlined } from '@ant-design/icons';

const { Title } = Typography;
const { TextArea } = Input;
const { Option } = Select;

const ProjectForm = ({ onBack, onSave }) => {
  const [form] = Form.useForm();

  const onFinish = (values) => {
    onSave(values); // Pass data to parent
    onBack(); // Go back to the list view
  };

  return (
    <div>
      <div style={{ marginBottom: '16px' }}>
        <Button onClick={onBack} icon={<ArrowLeftOutlined />}>
          กลับไปที่รายการโครงการ
        </Button>
      </div>
      <Card>
        <Title level={4}>สร้างโครงการใหม่</Title>
        <Form
          form={form}
          layout="vertical"
          onFinish={onFinish}
          initialValues={{
            status: 'active', // Default status to active
          }}
        >
          <Row gutter={16}>
            <Col xs={24} sm={12}>
              <Form.Item
                name="projectName"
                label="ชื่อโครงการ"
                rules={[{ required: true, message: 'กรุณาใส่ชื่อโครงการ' }]}
              >
                <Input placeholder="เช่น, Sena Village" />
              </Form.Item>
            </Col>
            <Col xs={24} sm={12}>
              <Form.Item
                name="status"
                label="สถานะ"
                rules={[{ required: true, message: 'กรุณาเลือกสถานะ' }]}
              >
                <Select>
                  <Option value="active">ใช้งาน</Option>
                  <Option value="inactive">ไม่ใช้งาน</Option>
                </Select>
              </Form.Item>
            </Col>
          </Row>
          <Form.Item
            name="location"
            label="ตำแหน่งที่ตั้ง"
            rules={[{ required: true, message: 'กรุณาใส่ตำแหน่งที่ตั้ง' }]}
          >
            <TextArea rows={4} placeholder="รายละเอียดที่อยู่โครงการ..." />
          </Form.Item>
          <Form.Item>
            <Button type="primary" htmlType="submit">
              บันทึกโครงการ
            </Button>
          </Form.Item>
        </Form>
      </Card>
    </div>
  );
};

export default ProjectForm;