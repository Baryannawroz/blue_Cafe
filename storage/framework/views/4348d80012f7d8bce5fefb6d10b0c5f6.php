<?php $__env->startSection('title'); ?>
    Add Dish
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/all-dish')); ?>" class="btn btn-default waves-effect">All Dish <span class="m-l-5"></span></a>
            </div>

            <h4 class="page-title">Create New Dish </h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="active">
                    Dish
                </li>
                <li class="active">
                    Edit Dish
                </li>
            </ol>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active">
            <a href="<?php echo e(url('/add-dish')); ?>" data-toggle="tab" aria-expanded="true">
                <span class="visible-xs"><i class="fa fa-cutlery"></i></span>
                <span class="hidden-xs">Dish Name</span>
            </a>
        </li>
        <li class="disabled">
            <a href="javascript:void(0);" data-toggle="tab" aria-expanded="false">
                <span class="visible-xs"><i class="">IQD</i></span>
                <span class="hidden-xs">Dish Price</span>
            </a>
        </li>
        <li class="disabled">
            <a href="javascript:void(0);" data-toggle="tab" aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-photo"></i></span>
                <span class="hidden-xs">Dish Images</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <form class="form-horizontal" role="form" action="<?php echo e(url('/save-dish')); ?>" id="addEmployee" method="post"
                  enctype="multipart/form-data" data-parsley-validate novalidate>
                <?php echo e(csrf_field()); ?>


                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Thumbnail <span class="text-danger">*</span> </label>
                    <div class="col md-10">
                        <div id="image-preview">
                            <label for="image-upload" id="image-label">Choose Photo</label>
                            <input type="file" name="thumbnail" id="image-upload" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Dish Name <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="dish" class="form-control" value=""
                               placeholder="Dish Name" parsley-trigger="change" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Category <span class="text-danger">*</span></label>
                    <div class="col-md-8 category-container">
                        <div class="input-group">
                            <select name="category_id" id="category_select" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn add-category" title="Add New Category"
                                        style="background: transparent">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-10">
                        <button type="submit" class="ladda-button btn btn-purple" data-style="expand-right">
                            Save Dish And Go Next
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add category button click handler
            document.querySelector('.add-category').addEventListener('click', function () {
                // Store the current form data in session storage to maintain state
                sessionStorage.setItem('dishFormData', JSON.stringify({
                    dish: document.querySelector('input[name="dish"]').value,
                    // Add other form fields as needed
                }));

                // Open category add page in new window
                var addWindow = window.open("<?php echo e(url('/add-dish-type')); ?>", "addCategoryWindow", "width=800,height=600");

                // Set up window message listener for when the category is added
                window.addEventListener('message', function (event) {
                    if (event.data.type === 'categoryAdded') {
                        console.log('yes category added', event.data)
                        // Add the new category to the dropdown and select it
                        var select = document.getElementById('category_select');
                        var option = new Option(event.data.categoryName, event.data.categoryId);
                        select.appendChild(option);
                        select.value = event.data.categoryId;

                        // Close the popup window if it's still open
                        if (addWindow && !addWindow.closed) {
                            addWindow.close();
                        }
                    }
                }, false);
            });

            // Restore form data when page loads (if available)
            var savedFormData = sessionStorage.getItem('dishFormData');
            if (savedFormData) {
                var formData = JSON.parse(savedFormData);
                document.querySelector('input[name="dish"]').value = formData.dish || '';
                // Restore other fields as needed

                // Clear the saved data
                sessionStorage.removeItem('dishFormData');
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/add-dish.blade.php ENDPATH**/ ?>