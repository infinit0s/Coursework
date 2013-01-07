
<?php if (in_array($user->role_name, $roles)): ?>
<a class="btn btn-primary btn-large" style="margin: 10px 0;" href="<?php echo base_url('index.php/employee/add') ?>">Add employee</a>
<?php endif; ?>

<?php

echo form_open(base_url('index.php/employee/all'), array('method' => 'get', 'class' => 'form-search'));
if ($canSeeComponent)
echo form_input(array(
    'name' => 'empno',
    'placeholder' => 'emp_no',
    'class' => 'search-query'
));
echo form_input(array(
    'name' => 'firstname',
    'placeholder' => 'firstname',
    'class' => 'search-query'
));
echo form_input(array(
    'name' => 'lastname',
    'placeholder' => 'lastname',
    'class' => 'search-query'
));
if ($canSeeComponent)
echo form_input(array(
    'name' => 'rolename',
    'placeholder' => 'rolename',
    'class' => 'search-query'
));
if ($canSeeComponent)
echo form_input(array(
    'name' => 'title',
    'placeholder' => 'title',
    'class' => 'search-query'
));
echo form_input(array(
    'name' => 'dept',
    'placeholder' => 'department',
    'class' => 'search-query'
));
echo form_button(array(
    'name' => 'button',
    'type' => 'submit',
    'content' => 'Search',
    'class' => 'btn btn-primary'
));
echo form_close();

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <?php if ($canSeeComponent): ?><th>emp_no</th><?php endif ?>
        <!--<th>birth_date</th>-->
        <th>first_name</th>
        <th>last_name</th>
        <!--<th>gender</th>-->
        <!--<th>hire_date</th>-->
        <?php if ($canSeeComponent): ?><th>role_name</th><?php endif ?>
        <?php if ($canSeeComponent): ?><th>title</th><?php endif ?>
        <th>department</th>
        <?php if ($canSeeComponent): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, $roles)): ?><th></th><?php endif; ?>
        <?php if (in_array($user->role_name, array('super'))): ?><th></th><?php endif; ?>

    </tr>
    </thead>
    <tbody>
    <?php if($results) { ?>
        <?php foreach ($results as $data) { ?>
        <tr>

            <?php if ($canSeeComponent): ?><td><?php echo $data->emp_no; ?></td><?php endif; ?>
            <!--<td><?php /*echo $data->birth_date; */?></td>-->
            <td><?php echo $data->first_name; ?></td>
            <td><?php echo $data->last_name; ?></td>
            <!--<td><?php /*echo $data->gender; */?></td>-->
            <!--<td><?php /*echo $data->hire_date; */?></td>-->
            <?php if ($canSeeComponent): ?><td><?php echo $data->name; ?></td><?php endif; ?>
            <?php if ($canSeeComponent): ?><td><?php echo $data->title;  ?></td><?php endif; ?>
            <td><?php echo $data->dept_name; ?></td>
            <?php if ($canSeeComponent): ?>
                <td class="icon"><a title="Details" href="<?php echo base_url('index.php/employee/details/'.$data->emp_no) ?>"><i class="icon-user" ></i></a></td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, $roles) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><a title="Remove" href="<?php echo base_url('index.php/employee/remove/'.$data->emp_no) ?>"><i class="icon-trash"></i></a> </td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, $roles) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><a title="Change department" href="<?php echo base_url('index.php/departments/change/'.$data->emp_no) ?>"><i class="icon-briefcase"></i></a> </td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, $roles) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><a title="Change title" href="<?php echo base_url('index.php/titles/edit/'.$data->emp_no) ?>"><i class="icon-pencil"></i></a> </td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, $roles) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><?php if (!$data->dept_man): ?><a title="Promote to manager" href="<?php echo base_url('index.php/departments/promote/'.$data->emp_no.'/'.$data->dept_no) ?>"><i class="icon-hand-up"></i></a><?php endif; ?></td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, $roles) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><?php if ($data->dept_man): ?><a title="Demotion" href="<?php echo base_url('index.php/departments/demote/'.$data->emp_no.'/'.$data->dept_no) ?>"><i class="icon-hand-down"></i></a><?php endif; ?></td>
            <?php endif; ?>
            <?php if (in_array($user->role_name, array('super')) && $user->emp_no != $data->emp_no): ?>
                <td class="icon"><a title="Change role" href="<?php echo base_url('index.php/employee/editrole/'.$data->emp_no) ?>"><i class="icon-star"></i></a> </td>
            <?php endif; ?>

        </tr>
            <?php }
    }?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="<?php echo $canSeeComponent ? 5 : 2 ?>"></td>

        </td>
        <td colspan="2">
            Page rendered in <strong>{elapsed_time}</strong> seconds
        </td>
    </tr>
    </tfoot>
</table>
<?php echo $links; ?>

