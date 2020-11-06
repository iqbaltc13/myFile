<template>
	<div id="sc-page-wrapper">
		<div id="sc-page-content">
			<div data-uk-grid>
				<div class="uk-width-expand@m">
					<div class="uk-child-width-1-3@l uk-child-width-1-2@m uk-grid" data-uk-grid>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Default</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab">
										<i class="mdi mdi-content-save"></i>
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Mini</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-small sc-fab-danger">
										<i class="mdi mdi-briefcase-plus"></i>
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Large</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-large sc-fab-primary">
										<i class="mdi mdi-autorenew"></i>
									</a>
								</div>
							</ScCard>
						</div>
					</div>
					<div class="uk-child-width-1-3@l uk-child-width-1-2@m uk-grid" data-uk-grid>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text default</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-text sc-fab-secondary">
										Create
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text small</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-small sc-fab-text sc-fab-secondary">
										Create
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text large</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-large sc-fab-text sc-fab-secondary">
										Create
									</a>
								</div>
							</ScCard>
						</div>
					</div>
					<div class="uk-child-width-1-3@l uk-child-width-1-2@m uk-grid" data-uk-grid>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text + icon default</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-text sc-fab-success">
										<i class="mdi mdi-plus"></i>Create
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text small</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-small sc-fab-text sc-fab-success">
										<i class="mdi mdi-plus"></i>Create
									</a>
								</div>
							</ScCard>
						</div>
						<div>
							<ScCard>
								<ScCardBody class="uk-height-small">
									<h5>Text large</h5>
								</ScCardBody>
								<div class="sc-fab-card-wrapper uk-position-bottom-right">
									<a href="javascript:void(0)" class="sc-fab sc-fab-large sc-fab-text sc-fab-success">
										<i class="mdi mdi-plus"></i>Create
									</a>
								</div>
							</ScCard>
						</div>
					</div>
				</div>
				<div class="uk-width-1-3@m uk-width-1-2@s">
					<ScCard>
						<ScCardBody class="uk-height-medium">
							<h5>Multiple</h5>
						</ScCardBody>
						<div class="sc-fab-card-wrapper uk-position-bottom-right">
							<a href="javascript:void(0)" class="sc-fab md-bg-light-green-600 sc-fab-dark">
								<i class="mdi mdi-send"></i>
							</a>
							<a href="javascript:void(0)" class="sc-fab md-bg-amber-600 sc-fab-dark">
								<i class="mdi mdi-reload"></i>
							</a>
							<a href="javascript:void(0)" class="sc-fab">
								<i class="mdi mdi-content-save"></i>
							</a>
						</div>
					</ScCard>
				</div>
			</div>
		</div>
		<div class="sc-fab-page-wrapper">
			<a href="javascript:void(0)" class="sc-fab sc-fab-large md-bg-light-blue-700 sc-fab-dark">
				<i class="mdi mdi-account-multiple-plus"></i>
			</a>
		</div>
	</div>
</template>
