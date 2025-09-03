import express from 'express';
import { protect, authorize } from '../middleware/auth.js';

const router = express.Router();

// All routes require authentication
router.use(protect);

// Placeholder for agent management routes
router.get('/', authorize('admin', 'manager'), (req, res) => {
  res.json({
    success: true,
    message: 'Agent routes - Coming soon',
    data: []
  });
});

export default router;