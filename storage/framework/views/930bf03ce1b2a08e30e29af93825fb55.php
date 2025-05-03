

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo e(__('Job Applications')); ?></span>
                    <a href="<?php echo e(route('job-applications.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Application
                    </a>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($jobApplications->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Position</th>
                                        <th>Location</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $jobApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($application->company_name); ?></td>
                                            <td><?php echo e($application->position); ?></td>
                                            <td><?php echo e($application->location ?? 'N/A'); ?></td>
                                            <td><?php echo e($application->application_date->format('M d, Y')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($application->status == 'applied' ? 'secondary' : 
                                                    ($application->status == 'interview' ? 'info' : 
                                                    ($application->status == 'offer' ? 'success' : 
                                                    ($application->status == 'rejected' ? 'danger' : 
                                                    ($application->status == 'accepted' ? 'primary' : 'warning'))))); ?>">
                                                    <?php echo e(ucfirst($application->status)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('job-applications.show', $application)); ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="<?php echo e(route('job-applications.edit', $application)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="<?php echo e(route('job-applications.destroy', $application)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
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
                            <h5>No job applications yet</h5>
                            <p>Start tracking your job search by adding your first application.</p>
                            <a href="<?php echo e(route('job-applications.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Job Application
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\akshi\OneDrive\Desktop\MVC\job-tracker\resources\views/job_applications/index.blade.php ENDPATH**/ ?>