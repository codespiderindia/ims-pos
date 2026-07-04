		<?php $this->load->view('include/layout_topbar');?>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<?php $this->load->view('include/layout_sidebar_nav');?>

			<div class="main-content">
				<?php $this->load->view('include/layout_breadcrumb');?>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">