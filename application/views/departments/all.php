<?php if ($canSee): ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>dept_no</th>
            <th>dept_name</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($result as $r): ?>
        <tr>
            <td><?php echo $r->dept_no ?></td>
            <td><?php echo $r->dept_name ?></td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>

