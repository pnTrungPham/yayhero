<?php
defined( 'ABSPATH' ) || exit;
?>
<table>
    <thead>
        <tr>
            <th><?php esc_html_e( 'Title', 'wpinternallinks' ); ?></th>
            <th><?php esc_html_e( 'Type', 'wpinternallinks' ); ?></th>
            <th><?php esc_html_e( 'Categories', 'wpinternallinks' ); ?></th>
            <th><?php esc_html_e( 'Anchor Text', 'wpinternallinks' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $links as $item ) : ?>
            <tr>
                <td><a href="<?php echo esc_url( get_edit_post_link( $item['ID'] ) ); ?>"><?php echo esc_html( $item['title'] ); ?></a></td>
                <td><?php echo esc_html( ucfirst( $item['type'] ) ); ?></td>
                <td><?php echo wp_kses_post( $item['categories'] ); ?></td>
                <td><?php echo wp_kses_post( $item['anchor_text'] ); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
