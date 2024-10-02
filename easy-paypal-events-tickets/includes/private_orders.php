<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpeevent_plugin_orders() {


	if (!isset($_GET['action']) || $_GET['action'] == "delete" || $_GET['action2'] == "delete" || ($_GET['action'] == "-1" && isset($_GET['s'])) ) {
	
		class wpeevent_button_orders_table extends WP_List_Table {
			
			
			function get_data() {
				global $wp_query;
				
				
				// search
				if (isset($_GET['s'])) {
					$s = sanitize_text_field($_GET['s']);
				} else {
					$s = "";
				}
				
				$args = array(
					'orderby' 			=> 'ID',
					'order' 			=> 'DESC',
					'posts_per_page'	=> -1,
					'post_type' 		=> 'wpplugin_event',
					'meta_query' 		=> array(
						'relation'=>'or',
						array(
							'key' 		=> 'wpeevent_button_payment_status',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_txn_id',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_payer_email',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_event_name',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_name_1',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_name_2',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_name_3',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_number_1',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_number_2',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   ),
					   	array(
							'key' 		=> 'wpeevent_button_item_number_3',
							'value' 	=> $s,
							'compare' 	=> 'LIKE',
					   )
					)
				);
				
				
				
				$posts = get_posts($args);


                $data = array();
				$count = "0";
				foreach ($posts as $post) {
					
					$id = 				$posts[$count]->ID;
					$post_title = 		esc_attr($posts[$count]->post_title);
					$post_date = 		esc_attr($posts[$count]->post_date);
					$item_number = 		esc_attr(get_post_meta($id,'wpeevent_button_item_number',true));
					$payment_status = 	esc_attr(get_post_meta($id,'wpeevent_button_payment_status',true));
					$payment_amount = 	esc_attr(get_post_meta($id,'wpeevent_button_payment_amount',true));
					$payer_email = 		esc_attr(get_post_meta($id,'wpeevent_button_payer_email',true));
					$event_name = 	esc_attr(get_post_meta($id,'wpeevent_button_event_name',true));
					$scanned = 	esc_attr(get_post_meta($id,'wpeevent_button_scanned',true));
					
					$item_name_1 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_name_1',true));
					$item_name_2 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_name_2',true));
					$item_name_3 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_name_3',true));
					
					$item_qty_1 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_qty_1',true));
					$item_qty_2 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_qty_2',true));
					$item_qty_3 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_qty_3',true));
					
					//$item_price_1 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_price_1',true));
					//$item_price_2 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_price_2',true));
					//$item_price_3 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_price_3',true));

					//$item_number_1 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_number_1',true));
					//$item_number_2 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_number_2',true));
					//$item_number_3 = 	esc_attr(get_post_meta($id,'wpeevent_button_item_number_3',true));
					
					
					$items = $item_name_1." (".$item_qty_1.")<br />";
					if ($item_name_2) {
						$items .= $item_name_2." (".$item_qty_2.")<br />";
					}
					if ($item_name_3) {
					$items .= $item_name_3." (".$item_qty_3.")<br />";
					}
					
					$order = $id;
					$item = $post_title."<br />".$item_number;
					
					if ($scanned == "1") {
						$scanned = "Yes";
					} else {
						$scanned = "No";
					}
					
					$data[] = array(
						'ID' => $id,
						'order' => $order,
						'items' => $items,
						'item' => $item,
						'amount' => $payment_amount,
						'event' => $event_name,
						'status' => $payment_status,
						'scanned' => $scanned,
						'email' => $payer_email,
						'date' => $post_date
					);
					
					$count++;
				}
				
				return $data;
			}
			
			
			
			function __construct() {
				global $status, $page;
				
				parent::__construct( array(
					'singular'  => 'order',
					'plural'    => 'orders',
					'ajax'      => false
				) );
			}


			function column_default($item, $column_name) {
				switch($column_name){
					case 'order':
					case 'items':
					case 'amount':
					case 'event':
					case 'status':
					case 'scanned':
					case 'email':
					case 'date':
						return $item[$column_name];
					default:
						return print_r($item,true);
				}
			}
			
			function column_order($item){
			
				// view
				$view_bare = '?page=wpeevent_menu&action=view&order='.$item['ID'];
				$view_url = wp_nonce_url($view_bare, 'view_'.$item['ID']);
				
				// delete
				$delete_bare = '?page=wpeevent_menu&action=delete&inline=true&order='.$item['ID'];
				$delete_url = wp_nonce_url($delete_bare, 'bulk-'.$this->_args['plural']);
				
				$actions = array(
					'edit'      => '<a href="' . esc_url($view_url) . '">View</a>',
					'delete'    => '<a href="' . esc_url($delete_url) . '">Delete</a>'
				);
				
				return sprintf('%1$s %2$s',
					esc_html($item['order']),
					$this->row_actions($actions)
				);
			}
			
			
			function column_cb($item) {
				return sprintf(
					'<input type="checkbox" name="%1$s[]" value="%2$s" />',
					esc_attr($this->_args['singular']),
					esc_attr($item['ID'])
				);
			}


			function get_columns() {
				$columns = array(
					'cb'        => '<input type="checkbox" />',
					'order'     => 'Order #',
					'items'     => 'Item name (Quantity sold)',
					'amount'	=> 'Total Amount',
					'event'		=> 'Event Name',
					'status'	=> 'Status',
					'scanned'	=> 'Scanned',
					'email'	=> 'Email',
					'date'		=> 'Date (YYYY-MM-DD HH-MM-SS)'
				);
				return $columns;
			}


			function get_sortable_columns() {
				$sortable_columns = array(
					'id'     => array('id',false),
					'order' => array('order',false)
				);
				return $sortable_columns;
			}
			
						
			function no_items() {
				_e( 'No orders found.' );
			}
			
			function get_bulk_actions() {
					$actions = array(
						'delete'    => 'Delete'
					);
					return $actions;
			}
			
			public function process_bulk_action() {
				if ( isset( $_GET['_wpnonce'] ) && ! empty( $_GET['_wpnonce'] ) ) {
					$nonce  = $_GET['_wpnonce'];
					$action = 'bulk-' . $this->_args['plural'];
					
					if ( ! wp_verify_nonce( $nonce, $action ) ) {
						wp_die('Security check fail');
					}
				}
			}
			
			function prepare_items() {
				global $wpdb;
				
				$per_page = 8;
				
				$columns = $this->get_columns();
				$hidden = array();
				$sortable = $this->get_sortable_columns();
				
				$this->_column_headers = array($columns, $hidden, $sortable);
				
				$this->process_bulk_action();
				
				$data = $this->get_data();
				
				if (isset($_REQUEST['orderby'])) {
					function usort_reorder($a,$b) {
						$orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'order';
						$order = (!empty($_REQUEST['order'])) ? sanitize_text_field($_REQUEST['order']) : 'asc';
						$result = strcmp($a[$orderby], $b[$orderby]);
						return ($order==='asc') ? $result : -$result;
					}
					usort($data, 'usort_reorder');
				}

				$current_page = $this->get_pagenum();
				
				

				$total_items = count($data);

				$data = array_slice($data,(($current_page-1)*$per_page),$per_page);




				$this->items = $data;

				$this->set_pagination_args( array(
					'total_items' => $total_items,
					'per_page'    => $per_page,
					'total_pages' => ceil($total_items/$per_page)
				) );
			}
		}
		
		
		function wpeevent_tt_render_list_pagea() {
			
			$testListTable = new wpeevent_button_orders_table();
			$testListTable->prepare_items();
			
			?>
			
			<style>
			.check-column {
				width: 2% !important;
			}
			.column-order {
				width: 10%;
			}
			.column-items {
				width: 18%;
			}
			.column-amount {
				width: 12%;
			}
			.column-event {
				width: 16%;
			}
			.column-status {
				width: 7%;
			}
			.column-scanned {
				width: 7%;
			}
			.column-email {
				width: 16%;
			}
			.column-date {
				width: 12%;
			}
			</style>			
			
			<div style="width:98%">
			
				<table width="100%"><tr><td>
				<br />
				<span style="font-size:20pt;">Orders</span>
				</td><td valign="bottom">
				</td></tr></table>
				
				<?php
                if (isset($_GET['message'])) {
                    switch ($_GET['message']){
                        case 'deleted':
                            echo "<div class='updated'><p>Order entry(s) deleted.</p></div>";
                            break;
                        case 'nothing':
                            echo "<div class='updated'><p>No action selected.</p></div>";
                            break;
                        case 'nothing_deleted':
                            echo "<div class='updated'><p>Nothing selected to delete.</p></div>";
                            break;
                        case 'error':
                            echo "<div class='updated'><p>An error occured while processing the query. Please try again.</p></div>";
                    }
                }
				?>
				
				<form id="products-filter" method="get">
					<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']) ?>" />
					<?php
					$testListTable->search_box( 'search', 'search_id' );
					$testListTable->display() ?>
				</form>
			
			</div>

			<?php
		}
		
		wpeevent_tt_render_list_pagea();
	}
	

	// end admin orders page view orders
	
	
	
	
	// admin orders page view order
	if (isset($_GET['action']) && $_GET['action'] == "view") {
		
		?>
		
		<div style="width:98%;">
		
			<?php
			$post_id = intval($_GET['order']);
			
			if (!$post_id) {
				echo'<script>window.location="admin.php?page=wpeevent_menu"; </script>';
				exit;
			}
			
			check_admin_referer('view_'.$post_id);
			
			$post_data = get_post($post_id);
			//$title = $post_data->post_title;
			$date = $post_data->post_date;
			$txn_id = get_post_meta($post_id,'wpeevent_button_txn_id',true);
			?>
				
			<table width="100%"><tr><td valign="bottom" width="85%">
			<br />
			<span style="font-size:20pt;">View Order</span>
			</td><td valign="bottom">
			<a href="?page=wpeevent_menu" class="button-secondary" style="font-size: 14px;height: 30px;float: right;">View All Orders</a>
			</td></tr></table>
			
			<?php
			// error
			if (isset($error) && isset($message)) {
				echo "<div class='error'><p>"; echo esc_html($message); echo"</p></div>";
			}
			// saved
			if (!isset($error) && isset($message)) {
				echo "<div class='updated'><p>"; echo esc_html($message); echo"</p></div>";
			}
			?>
			
			<br />
			
			<div style="background-color:#fff;padding:8px;border: 1px solid #CCCCCC;"><br />
			
				<span style="font-size:16pt;">Order #<?php echo esc_html($post_id); ?> Details</span>
				<br /><br />
				
				<table width="430px"><tr><td>
					
					<b>Transaction</b></td></tr><tr><td>
					PayPal Transaction ID: </td><td><a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo esc_attr($txn_id); ?>"><?php echo esc_html($txn_id); ?></a></td></tr><tr><td>
					Order Date: </td><td><?php echo esc_html($date); ?></td></tr><tr><td>
					Order Status: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payment_status',true)); ?></td></tr><tr><td>
					Total Amount: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payment_amount',true)); ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Payer</b></td></tr><tr><td>
					Payer Email: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payer_email',true)); ?></td></tr><tr><td>
					Payer Currency: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_payment_currency',true)); ?></td></tr><tr><td>
					eTicket Scanned: </td><td><?php	if (get_post_meta($post_id,'wpeevent_button_scanned',true) == "1") { echo "Yes"; } else { echo "No"; } ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Event</b></td></tr><tr><td>
					Event Name: </td><td><?php echo esc_html(get_post_meta($post_id,'wpeevent_button_event_name',true)); ?></td></tr><tr><td>
					
					<br /></td><td></td></tr><tr><td>
					<b>Items Sold</b></td></tr><tr>
					
					<?php
					// pre count for border seperator
						for( $i = 0; $i<20; $i++ ) {
							$wpeevent_button_item_name = get_post_meta($post_id,"wpeevent_button_item_name_$i",true);
							if (isset($wpeevent_button_item_name)) {
								$count = $i;
							}
						}
						
						$custom = intval(get_post_meta($post_id,'wpeevent_button_custom',true));
						
						$out = "";
						for( $i = 0; $i<20; $i++ ) {
							if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
								$out .= "<td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>";
								$out .= "#" . esc_html($i) . " </td><td width='120px'>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_name',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_name_$i",true)); $out .= "</td></tr><tr><td></td><td>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_title',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_qty_$i",true)); $out .="</td></tr><tr><td></td><td>";
								$out .= "ID"; $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_number_$i",true)); $out .="</td></tr><tr><td></td><td>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_price',true)); $out .= "</td><td>"; $amount = esc_html(get_post_meta($post_id,"wpeevent_button_item_price_$i",true)); $out .= number_format((float)$amount, 2, '.', '');
								if ($count == $i) {
									$out .= "</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'>";
								} else {
									$out .= "</td></tr><tr><td>";
								}
								$out .= "</td></tr><tr>";
							}
						}
						
						
						echo $out;
						
					?>
					
					</tr><tr><td><br />
					<b>Other</b></td></tr><tr>
					
					</td><td>Resend eTicket: </td><td>Email:
					
					<form action='<?php echo esc_url($_SERVER["REQUEST_URI"]); ?>' method="POST">
					<input type="text" name="email" value="<?php echo esc_attr(get_post_meta($post_id,'wpeevent_button_payer_email',true)); ?>" style="width:180px;">
					<br /><?php if(isset($_GET['status']) && $_GET['status'] == "1") { echo "<b>Email Sent</b>"; } if(isset($_GET['status']) && $_GET['status'] == "2") { echo "<b>Enter email address</b>"; } ?>
					</td><td>
					<input type="hidden" name="send_customer_email" value="1">
					<input type="submit" value="Resend"><br />
					</form>
					</td>
					
					
					
					<?php
					if (isset($_POST['send_customer_email'])) {
						$send_customer_email = "1";
						
						$payer_email = sanitize_email($_POST['email']);
						
							if (empty($payer_email)) {
							?>
							<script type="text/javascript">
							<!--
							window.location = "?page=wpeevent_menu&action=view&status=2&order=<?php echo esc_attr($post_id); ?>&_wpnonce=<?php echo esc_attr($_GET['_wpnonce']); ?>"
							//-->
							</script>
							<?php
							exit;
						}
						
						$txn_id = esc_attr(get_post_meta($post_id,'wpeevent_button_txn_id',true));
						$payment_amount = esc_attr(get_post_meta($post_id,'wpeevent_button_payment_amount',true));
						$event_name = esc_attr(get_post_meta($post_id,'wpeevent_button_event_name',true));
						
						
						// pre count for border seperator
						for( $i = 0; $i<20; $i++ ) {
							if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
								$count  = $i;
							}
						}
						
						$custom = get_post_meta($post_id,'wpeevent_button_custom',true);
						
						$out = "<table width='400px'>";
						for( $i = 0; $i<20; $i++ ) {
							if (get_post_meta($post_id,"wpeevent_button_item_name_$i",true)) {
								$out .= "<td colspan='3' style='border-top:1px dashed #888;'></td></tr><tr><td width='30px'>";
								$out .= "#$i </td><td width='120px'>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_name',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_name_$i",true)); $out .= "</td></tr><tr><td></td><td>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_title',true)); $out .= "</td><td>"; $out .= esc_html(get_post_meta($post_id,"wpeevent_button_item_qty_$i",true)); $out .="</td></tr><tr><td></td><td>";
								$out .= esc_html(get_post_meta($custom,'wpeevent_button_h_price',true)); $out .= "</td><td>"; $amount = esc_html(get_post_meta($post_id,"wpeevent_button_item_price_$i",true)); $out .= number_format((float)$amount, 2, '.', '');
								if ($count == $i) {
									$out .= "</td></tr><tr><td colspan='3' style='border-top:1px dashed #888;'>";
								} else {
									$out .= "</td></tr><tr><td>";
								}
								$out .= "</td></tr><tr>";
							}
						}
						$out .= "</tr></table>";
						
						
						
						$item_name = $out;
						
						
						$post_data = get_post($post_id);
						$post_date = $post_data->post_date;
						$hash = md5($post_date);
						$custom = $post_id;
						$qr_url = get_admin_url() . "admin-post.php?action=add_wpeevent_button_qr&order=$custom|$post_id|$hash";
						$qr_url = urlencode($qr_url);
						$qr_code = "<img src='https://quickchart.io/chart?cht=qr&chs=150x150&chl=$qr_url&choe=UTF-8' />";
						
						include_once ('private_emails.php');
						?>
						<script type="text/javascript">
							<!--
							window.location = "?page=wpeevent_menu&action=view&status=1&order=<?php echo esc_attr($post_id); ?>&_wpnonce=<?php echo esc_attr($_GET['_wpnonce']); ?>"
							//-->
						</script>
						<?php
					}
					?>
					
					
				</tr></table>
				
				
				<br /><br />
				
			</div>
		</div>
		
		<?php	
		
	}
	// end admin orders page view order
	
	
	// admin orders page delete order
	if (isset($_GET['action']) && $_GET['action'] == "delete" || isset($_GET['action2']) && $_GET['action2'] == "delete") {
		
		if ($_GET['inline'] == "true") {
			$post_id = array(intval($_GET['order']));
		} else {
			$post_id = array_map('intval', $_GET['order']);
		}
		
		if (empty($post_id)) {
			echo'<script>window.location="?page=wpeevent_menu&message=nothing_deleted"; </script>';
		}
		
		foreach ($post_id as $to_delete) {
			if (!$to_delete) {
				echo'<script>window.location="?page=wpeevent_buttons&message=error"; </script>';
				exit;
			}
			
			wp_delete_post($to_delete,1);
			delete_post_meta($to_delete,'wpeevent_button_item_number');
			delete_post_meta($to_delete,'wpeevent_button_payment_status');
			delete_post_meta($to_delete,'wpeevent_button_payment_amount');
			delete_post_meta($to_delete,'wpeevent_button_payment_cycle');
			delete_post_meta($to_delete,'wpeevent_button_txn_id');
			delete_post_meta($to_delete,'wpeevent_button_payer_email');
			
		}
		
		echo'<script>window.location="?page=wpeevent_menu&message=deleted"; </script>';
		
	}
	// end admin orders page delete order
	
	// admin orders page no action taken
	if (isset($_GET['action']) && $_GET['action'] == "-1" && !isset($_GET['s']) ) {
		
		echo'<script>window.location="?page=wpeevent_menu&message=nothing"; </script>';
		
	}
	// end admin orders page no action taken
	
}