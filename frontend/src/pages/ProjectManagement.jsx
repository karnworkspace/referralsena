import React, { useState } from 'react';
import {
  Card,
  Button,
  Row,
  Col,
  Typography,
  Table,
  Tag
} from 'antd';
import { PlusOutlined, ProjectOutlined } from '@ant-design/icons';
import ProjectForm from './ProjectForm';

const { Title } = Typography;

const ProjectManagement = () => {
  const [view, setView] = useState('list'); // 'list' or 'form'
  const [projects, setProjects] = useState([
    { id: 1, projectName: 'Sena Village Tiwanon', location: 'Tiwanon Road, Nonthaburi', status: 'active' },
    { id: 2, projectName: 'Sena Park Grand Ramindra', location: 'Ramindra Road, Bangkok', status: 'inactive' }
  ]);

  const handleCreate = () => {
    setView('form');
  };

  const handleBack = () => {
    setView('list');
  };

  const handleSaveProject = (newProject) => {
    setProjects(prevProjects => [
      ...prevProjects,
      { id: Date.now(), ...newProject } // Use timestamp for a more unique ID
    ]);
  };

  if (view === 'form') {
    return <ProjectForm onBack={handleBack} onSave={handleSaveProject} />;
  }

  const columns = [
    {
      title: 'ชื่อโครงการ',
      dataIndex: 'projectName',
      key: 'projectName',
    },
    {
      title: 'ตำแหน่งที่ตั้ง',
      dataIndex: 'location',
      key: 'location',
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
  ];

  return (
    <div style={{ padding: '24px' }}>
      <Card>
        <div style={{ marginBottom: '16px' }}>
          <Row justify="space-between" align="middle">
            <Col>
              <Title level={3} style={{ margin: 0 }}>
                <ProjectOutlined style={{ marginRight: '8px' }} />
                จัดการโครงการ
              </Title>
            </Col>
            <Col>
              <Button
                type="primary"
                icon={<PlusOutlined />}
                onClick={handleCreate}
              >
                เพิ่มโครงการใหม่
              </Button>
            </Col>
          </Row>
        </div>
        
        <Table
          columns={columns}
          dataSource={projects}
          rowKey="id"
        />
      </Card>
    </div>
  );
};

export default ProjectManagement;