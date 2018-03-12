<h1><?php echo get_option('blogname'); ?> (<?php echo get_option('home'); ?>)</h1>
<h2>
    <?php _e('Customer Feedback', 'customer-feedback'); ?> - <?php _e('Summary report', 'customer-feedback'); ?>
    <?php
        echo (!is_null($from) || !is_null($to)) ? '(' : '';

            if (!is_null($from) && !is_null($to)) {
                if ($from === $to) {
                    echo $from;
                } else {
                    echo $from . ' ' . __('to', 'customer-feedback') . ' ' . $to;
                }
            } else {
                if (!is_null($from)) {
                    echo $from . ' -';
                }

                if (!is_null($to)) {
                    echo '- ' . $to;
                }
            }

        echo (!is_null($from) || !is_null($to)) ? ')' : '';
    ?>
</h2>
<table cellspacing="0" cellpadding="0" style="border:1px solid #ddd;background-color: #f9f9f9;" width="800">
    <tr>
        <td colspan="2" style="border-bottom:1px solid #ddd;padding:9px 14px;"><strong><?php _e('Overall answer summary', 'customer-feedback'); ?></strong></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px solid #ddd;padding:14px;">
            <strong style="font-size: 17px;"><?php echo $mainQuestion ?></strong><br>
            <?php echo $mainQuestionSub; ?>
        </td>
    </tr>
    <tr>
        <td style="border-right:1px solid #ddd;padding:14px;">
            <strong style="color:#30BA41;"><?php _e('Yes'); ?></strong>
            <?php echo $data['percent']['yes'] . '% (' . $data['count']['yes'] . ')'; ?>
        </td>
        <td style="padding:14px;">
            <strong style="color:#BA3030;"><?php _e('No'); ?></strong>
            <?php echo $data['percent']['no'] . '% (' . $data['count']['no'] . ')'; ?>
        </td>
    </tr>
</table>

<?php if (count($data['pending']) > 0) : ?>
<h2><?php _e('Pending feedback', 'customer-feedback'); ?></h2>
<?php foreach ($data['pending'] as $pending) : ?>
<table cellspacing="0" cellpadding="0" style="border:1px solid #ddd;background-color: #f9f9f9;margin-bottom:5px;" width="800">
    <?php foreach ($pending->answer['topics'] as $topic): ?>
    <tr>
        <td colspan="100" style="border-bottom:1px solid #ddd;padding:14px;">
            <?php echo __('Topic', 'customer-feedback') . ': ' . $topic; ?>
        </td>
    </tr>
    <?php endforeach ?>
    <tr>
        <td colspan="100" style="border-bottom:1px solid #ddd;padding:14px;">
            <?php echo $pending->answer['comment']; ?>
        </td>
    </tr>
    <tr>
        <td style="padding:9px 14px;text-align:center;width:50%;">
            <?php echo mysql2date('Y-m-d H:i', $pending->post_date); ?>
        </td>

        <td style="padding:9px 14px;border-left:1px solid #ddd;text-align:center;width:50%;">
            <a href="<?php echo get_permalink($pending->answer['post_id']); ?>"><?php _e('View page', 'customer-feedback'); ?></a>
        </td>
    </tr>
</table>
<?php endforeach; ?>
<?php endif; ?>
