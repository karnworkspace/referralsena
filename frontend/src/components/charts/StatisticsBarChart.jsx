import React from 'react';
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  Legend
} from 'recharts';
import { Card } from 'antd';

const StatisticsBarChart = ({ data, title = "สถิติรวม" }) => {
  // Transform data for chart
  const chartData = [
    {
      name: 'เอเจนต์',
      ทั้งหมด: data.totalAgents || 0,
      ใช้งาน: data.activeAgents || 0,
      รออนุมัติ: data.pendingAgents || 0
    },
    {
      name: 'ลูกค้า',
      ทั้งหมด: data.totalCustomers || 0,
      ใหม่: data.newCustomers || 0,
      รออนุมัติ: data.pendingCustomers || 0
    }
  ];

  // Custom tooltip
  const CustomTooltip = ({ active, payload, label }) => {
    if (active && payload && payload.length) {
      return (
        <div style={{
          backgroundColor: 'white',
          border: '1px solid #d9d9d9',
          borderRadius: '6px',
          padding: '10px',
          boxShadow: '0 2px 8px rgba(0,0,0,0.1)'
        }}>
          <p style={{ margin: 0, fontWeight: 'bold', color: '#1890ff' }}>
            {`${label}`}
          </p>
          {payload.map((entry, index) => (
            <p key={index} style={{
              margin: '4px 0',
              color: entry.color,
              fontSize: '14px'
            }}>
              {`${entry.dataKey}: ${entry.value} คน`}
            </p>
          ))}
        </div>
      );
    }
    return null;
  };

  return (
    <Card title={title} style={{ height: '280px' }}>
      <ResponsiveContainer width="100%" height={200}>
        <BarChart
          data={chartData}
          margin={{
            top: 5,
            right: 30,
            left: 20,
            bottom: 5,
          }}
          barCategoryGap="20%"
        >
          <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
          <XAxis
            dataKey="name"
            tick={{ fontSize: 14, fill: '#666' }}
            axisLine={{ stroke: '#d9d9d9' }}
          />
          <YAxis
            tick={{ fontSize: 12, fill: '#666' }}
            axisLine={{ stroke: '#d9d9d9' }}
          />
          <Tooltip content={<CustomTooltip />} />
          <Legend
            wrapperStyle={{ paddingTop: '10px' }}
          />
          <Bar
            dataKey="ทั้งหมด"
            fill="#1890ff"
            radius={[2, 2, 0, 0]}
            name="ทั้งหมด"
          />
          <Bar
            dataKey="ใช้งาน"
            fill="#52c41a"
            radius={[2, 2, 0, 0]}
            name="ใช้งาน/ใหม่"
          />
          <Bar
            dataKey="รออนุมัติ"
            fill="#fa8c16"
            radius={[2, 2, 0, 0]}
            name="รออนุมัติ"
          />
        </BarChart>
      </ResponsiveContainer>
    </Card>
  );
};

export default StatisticsBarChart;