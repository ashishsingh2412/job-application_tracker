

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo e(__('Reminders')); ?></span>
                    <div>
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="<?php echo e(route('reminders.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Reminder
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($reminders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Job Application</th>
                                        <th>Date/Time</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="<?php echo e($reminder->is_completed ? 'text-muted' : ($reminder->reminder_date->isPast() ? 'table-danger' : '')); ?>">
                                            <td><?php echo e($reminder->title); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('job-applications.show', $reminder->jobApplication)); ?>">
                                                    <?php echo e($reminder->jobApplication->company_name); ?> - <?php echo e($reminder->jobApplication->position); ?>

                                                </a>
                                            </td>
                                            <td><?php echo e($reminder->reminder_date->format('M d, Y g:i A')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($reminder->priority == 'low' ? 'success' : 
                                                    ($reminder->priority == 'medium' ? 'warning' : 'danger')); ?>">
                                                    <?php echo e(ucfirst($reminder->priority)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <form action="<?php echo e(route('reminders.toggle-complete', $reminder)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="btn btn-sm <?php echo e($reminder->is_completed ? 'btn-outline-success' : 'btn-outline-secondary'); ?>">
                                                        <?php echo e($reminder->is_completed ? 'Completed' : 'Mark Complete'); ?>

                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('reminders.show', $reminder)); ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="<?php echo e(route('reminders.edit', $reminder)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="<?php echo e(route('reminders.destroy', $reminder)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reminder?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <h5>No reminders yet</h5>
                            <p>Create reminders to help you follow up on job applications.</p>
                            <a href="<?php echo e(route('reminders.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Reminder
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\akshi\OneDrive\Desktop\MVC\job-tracker\resources\views/reminders/index.blade.php ENDPATH**/ ?>