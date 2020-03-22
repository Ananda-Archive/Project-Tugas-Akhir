<?php require('template/header.php'); ?>
    <title>Home</title>
    </head>
	<body>
		<div id="app">
			<v-app>
				<?php require('template/navbar.php') ?>
				<v-content>
					<v-layout fill-height>
                        <v-container fluid>
                            <v-row :align="center">
                                <v-col cols="12" sm="12" md="4">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="245" max-height="245">
										<div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">STATUS PENDAFTARAN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-chart-timeline-variant</v-icon></v-card-title>
											</div>
										</div>
                                        <v-card-title class="red--text justify-center display-4 mb-n4">0</v-card-title>
                                        <v-card-title class="justify-center font-weight-thin body-1">Mahasiswa Belum Terdaftar</v-card-title>
                                    </v-card>
                                </v-col>
								<v-col cols="12" sm="12" md="4">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="245" max-height="245">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">JADWAL PENDAFTARAN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-calendar-clock</v-icon></v-card-title>
											</div>
										</div>
                                        <v-card-title class="justify-center font-weight-thin headline">12 Januari 2020</v-card-title>
                                        <v-card-title class="justify-center caption ma-n4">s/d</v-card-title>
                                        <v-card-title class="justify-center font-weight-thin headline">30 Maret 2020</v-card-title>
                                    </v-card>
                                </v-col>
								<v-col cols="12" sm="12" md="4">
                                    <v-card @click="" class="elevation-12 align-center" color="blue" min-height="245" max-height="245">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">MAHASISWA & DOSEN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center my-n4"><v-icon class="display-4">mdi-account-group-outline</v-icon></v-card-title>
										<v-card-title class="justify-center font-weight-thin body-1 mb-n4">Lihat List Mahasiswa & Dosen</v-card-title>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-layout>
				</v-content>
			</v-app>
		</div>

		<script>
			new Vue({
				el: '#app',
				vuetify: new Vuetify(),

				created() { 
					this.$vuetify.theme.dark = true
				},

				data() {
					return {
						profileImage:''
					}
				},

				methods: {
                    logOut() {
                        window.location.href = '<?=base_url('home/logOut');?>'
                    }
				},
				
				computed: {
					//view Breakpoint
                    popUpBreakPoint() {
                        if (this.$vuetify.breakpoint.name == 'xs') {
                            return true
                        } else {
                            return false
                        }
                    }
				},

			})
		</script>
	</body>

</html>