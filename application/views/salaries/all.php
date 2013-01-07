<?php if ($canSee): ?>

<?php if (in_array($user->role_name, array('super'))): ?>
    <a class="btn btn-primary btn-large" style="margin: 10px 0;" href="<?php echo base_url('index.php/salaries/increase') ?>">Increase Salaries</a>
    <?php endif; ?>

<?php

echo form_open(base_url('index.php/salaries/all'), array('method' => 'get', 'class' => 'form-search'));

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
        <th>emp_no</th>
        <th>first_name</th>
        <th>last_name</th>
        <th>salary</th>
        <th>from_date</th>
        <th>to_date</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if($results) { ?>
        <?php foreach ($results as $data) { ?>
        <tr>
            <td><?php echo $data->emp_no; ?></td>
            <td><?php echo $data->first_name; ?></td>
            <td><?php echo $data->last_name; ?></td>
            <td><?php echo $data->salary; ?></td>
            <td><?php echo $data->from_date;  ?></td>
            <td><?php echo $data->to_date; ?></td>
            <td class="icon"><?php if (date("Y-m-d") < $data->to_date): ?><a class="icon-edit" title="Edit salary" href="<?php echo base_url('index.php/salaries/edit/'.$data->emp_no) ?>"></a><?php endif; ?></td>
        </tr>
            <?php }
    }?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5">

        </td>
        <td colspan="2">
            Page rendered in <strong>{elapsed_time}</strong> seconds
        </td>
    </tr>
    </tfoot>
</table>
<?php echo $links; ?>

<?php endif; ?>