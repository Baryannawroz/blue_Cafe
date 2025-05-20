<?php $__env->startSection('title'); ?>
    Dish Price - <?php echo e($dish->dish); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/all-dish')); ?>" class="btn btn-default waves-effect">All Dish <span class="m-l-5"></span></a>
            </div>

            <h4 class="page-title">Edit Dish </h4>
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
        <li class="">
            <a href="<?php echo e(url('/edit-dish/'.$dish->id)); ?>" aria-expanded="true">
                <span class="visible-xs"><i class="fa fa-cutlery"></i></span>
                <span class="hidden-xs"><?php echo e($dish->dish); ?></span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(url('/dish-price/'.$dish->id)); ?>" aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-usd"></i></span>
                <span class="hidden-xs">Dish Price</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(url('/dish-image/'.$dish->id)); ?>" aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-photo"></i></span>
                <span class="hidden-xs">Dish Images</span>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo e(url('/dish-recipe/'.$dish->id)); ?>" data-toggle="tab" aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-photo"></i></span>
                <span class="hidden-xs">Recipe</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <form class="form-horizontal" role="form" action="<?php echo e(url('/save-recipes/'.$dish->id)); ?>" id="updateDish"
                  method="post"
                  enctype="multipart/form-data" data-parsley-validate novalidate>
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Dish Type</label>
                    <div class="col-md-8">
                        <select name="dish_type_id" id="" class="form-control" required>
                            <option value="">Select one</option>
                            <?php $__currentLoopData = $dish->dishPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dishType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dishType->id); ?>"><?php echo e($dishType->dish_type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="example-email">Product :</label>
                    <div class="col-md-8">
                        <select name="product_id" id="product" class="form-control" required>
                            <option value="">Select One</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->product_name); ?>

                                    &nbsp;&nbsp;&nbsp; <?php echo e($product->product_code); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="example-email">Unit need to cook :</label>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="number" name="unit" class="form-control" id="unit_input" step="0.01" required>
                            <span class="input-group-addon" id="unit">.00</span>
                        </div>
                    </div>
                    <label class="col-md-2 control-label" for="example-email">Child Unit need to cook
                        :</label>
                    <div class="col-md-3 input-group">
                        <input type="number" name="child_unit" class="form-control" id="child_unit_input" step="0.01"
                               required>
                        <span class="input-group-addon" id="childUnit">.00</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-purple">Add Product to recipe

                        </button>
                    </div>
                </div>

            </form>


            <?php $__currentLoopData = $dish->dishPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dishInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <h2><?php echo e($dishInfo->dish_type); ?></h2>
                <div class="p-20">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Child Unit</th>
                                <th>Creator</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1; ?>
                            <?php $__currentLoopData = $dish->dishRecipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($recipe->dishType->dish_type == $dishInfo->dish_type): ?>
                                    <tr>
                                        <td><?php echo e($count++); ?></td>
                                        <td><?php echo e($recipe->product->product_name); ?></td>
                                        <td><?php echo e($recipe->unit_needed); ?> - <?php echo e($recipe->product->unit->unit); ?></td>
                                        <td><?php echo e($recipe->child_unit_needed); ?> - <?php echo e($recipe->product->unit->child_unit); ?></td>
                                        <td><?php echo e($recipe->user_id); ?></td>
                                        <td>
                                            <a href="<?php echo e(url('/delete-recipes/'.$recipe->id)); ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>

    <script src="<?php echo e(url('/dashboard/plugins/select2/js/select2.min.js')); ?>"></script>

    <script>
        var convert_rate = 0;
        $(document).ready(function () {
            $("#unit_input").on('keyup', function () {
                if (convert_rate != 0) {
                    $("#child_unit_input").val($("#unit_input").val() * convert_rate);
                }

            });

            $("#child_unit_input").on('keyup', function () {
                if (convert_rate != 0) {
                    $("#unit_input").val($("#child_unit_input").val() / convert_rate);
                }
            });
            $("#product").on('change', function () {
                $.get('/get-unit-of-product/' + $("#product").val(), function (data) {
                    console.log(data);
                    $("#unit").text(data.unit.unit);
                    $("#childUnit").text(data.unit.child_unit);
                    convert_rate = data.unit.convert_rate;
                });
            });

        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/dish-recipe/add-dish-recipe.blade.php ENDPATH**/ ?>