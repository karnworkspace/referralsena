import React, { useState } from 'react';
import {
  Card,
  Button,
  Row,
  Col,
  Typography,
  Table,
  Tag,
  Space,
  Popconfirm,
  message
} from 'antd';
import { PlusOutlined, ProjectOutlined, EditOutlined, DeleteOutlined } from '@ant-design/icons';
import ProjectForm from './ProjectForm';

const { Title } = Typography;

const ProjectManagement = () => {
  const [view, setView] = useState('list'); // 'list' or 'form'
  const [editingProject, setEditingProject] = useState(null);
  const [projects, setProjects] = useState([
    { id: 1, projectName: 'Sena Village Tiwanon', location: 'Tiwanon Road, Nonthaburi', status: 'active' },
    { id: 2, projectName: 'Sena Park Grand Ramindra', location: 'Ramindra Road, Bangkok', status: 'inactive' }
  ]);

  const handleCreate = () => {
    setEditingProject(null);
    setView('form');
  };

  const handleEdit = (project) => {
    setEditingProject(project);
    setView('form');
  };

  const handleDelete = (projectId) => {
    setProjects(prevProjects => prevProjects.filter(p => p.id !== projectId));
    message.success('ลบโครงการสำเร็จ');
  };

  const handleBack = () => {
    setView('list');
    setEditingProject(null);
  };

  const handleSaveProject = (projectData) => {
    if (editingProject) {
      // Update existing project
      setProjects(prevProjects =>
        prevProjects.map(p =>
          p.id === editingProject.id ? { ...p, ...projectData } : p
        )
      );
      message.success('แก้ไขโครงการสำเร็จ');
    } else {
      // Create new project
      setProjects(prevProjects => [
        ...prevProjects,
        { id: Date.now(), ...projectData }
      ]);
      message.success('เพิ่มโครงการสำเร็จ');
    }
    setView('list');
    setEditingProject(null);
  };

  if (view === 'form') {
    return <ProjectForm
      onBack={handleBack}
      onSave={handleSaveProject}
      editingProject={editingProject}
    />;
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
    {
      title: 'การดำเนินการ',
      key: 'actions',
      width: 120,
      render: (_, record) => (
        <Space>
          <Button
            type="primary"
            icon={<EditOutlined />}
            size="small"
            onClick={() => handleEdit(record)}
          />
          <Popconfirm
            title="ยืนยันการลบ"
            description="คุณแน่ใจหรือไม่ที่จะลบโครงการนี้?"
            onConfirm={() => handleDelete(record.id)}
            okText="ใช่"
            cancelText="ไม่"
          >
            <Button
              danger
              icon={<DeleteOutlined />}
              size="small"
            />
          </Popconfirm>
        </Space>
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