<?php
defined( 'ABSPATH' ) || exit;
?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table td.copy {
        text-align: center;
    }
</style>

<table>
    <thead>
        <tr>
            <th><b><?php esc_html_e( 'Phrases In This Post To Link From', 'wpinternallinks' ); ?></b></th>
            <th><b><?php esc_html_e( 'Suggested Posts To Link To', 'wpinternallinks' ); ?></b></th>
            <th><b><?php esc_html_e( 'Action', 'wpinternallinks' ); ?></b></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $suggestions as $suggestion ) { ?>
            <tr>
                <td>                 
                    <?php echo esc_html( $suggestion['anchor_text'] ); ?>
                </td>
                <td>
                    <div>
                        <strong>Title:</strong> 
                        <span><i><strong><?php echo esc_html( $suggestion['title_post_outbound'] ); ?></strong></i></span>
                    </div>
                    <div>
                        <strong>Url:</strong> 
                        <span><a href="<?php echo esc_url( $suggestion['url_post_outbound'] ); ?>"><?php echo esc_url( $suggestion['url_post_outbound'] ); ?></a></span>
                    </div>
                </td>
                <td> 
                    <a href="#" class="button button-primary"><?php esc_html_e( 'Copy', 'wpinternallinks' ); ?></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    </tbody>
</table>
