<?php require('template/header.php'); ?>
    <title>Home</title>
    </head>
	<body>
	
		<div id="app">
			<v-app>
				<?php require('template/navbar.php') ?>
				<v-content>
					<v-layout>
                        <v-container  fluid>
                            <v-row justify="center">
                                <v-avatar color="#2196F3" disabled size="200" class="mt-8"><span class="white--text display-4"><?=$nama[0]?></span></v-avatar>
                            </v-row>
                        </v-container>
                    </v-layout>
					<v-layout>
                        <v-container fluid>
                            <v-row align="center" justify="center">
								<v-col cols="12" sm="12" md="12">
                                    <v-row justify="center"><span class="display-2 text-center mt-n4"><?=$nama?></span></v-row>
                                </v-col>
								<v-col cols="12" sm="12" md="12">
                                    <v-row justify="center"><span class="body-2 font-weight-thin mt-n4 mb-n4"><?=$nomor?></span></v-row>
                                </v-col>
							</v-row>
						</v-container>
					</v-layout>
					<v-layout>
                        <v-container fluid>
                            <v-row align="center">
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="uploadNewBerkasDialog = !uploadNewBerkasDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">UPLOAD BERKAS</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-account</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-book-plus-multiple</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="uploadNewBerkasDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Upload Berkas Baru</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-card-text>
											<v-row align="center" justify="center">
												<v-col cols="12">
													<!-- HANYA MENERIMA PDF, DOCX, DOC, ZIP, DAN RAR MIME TYPE -->
													<v-form ref="form">
														<v-file-input
															class="mt-4 mb-n4"
															v-model="file"
															color="blue"
															label="File input"
															placeholder="Select your file"
															prepend-icon="mdi-paperclip"
															outlined
															:rules="fileRule"
															:show-size="1000"
															accept="application/vnd.rar,application/zip,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf"
														>
															<template v-slot:selection="{ index, text }">
																<v-chip
																	v-if="file != ''"
																	color="blue"
																	dark
																	label
																	small
																>
																	{{ text }}
																</v-chip>
															</template>
														</v-file-input>
													</v-form>
												</v-col>
											</v-row>
										</v-card-text>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" :disabled="files.length != 0 && files[0].status_dosen_pembimbing == 0 && files[0].status_ketua_penguji == 0 && files[0].status_dosen_penguji == 0" color="green white--text" @click="uploadBerkasBaru">Upload</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="files.length != 0">
                                    <v-card @click="viewStatusBerkas = !viewStatusBerkas" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">STATUS BERKAS</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-clock-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-clock-fast</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="viewStatusBerkas" max-width="900px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Status Berkas</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-card-text>
											<v-simple-table class="my-2">
												<template v-slot:default>
													<thead>
														<tr>
															<th>Dosen</th>
															<th width="20%">Status</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ revealDosenPembimbing(files[0].id_dosen_pembimbing) }} <span v-if="files[0].status_dosen_pembimbing == 2" class="ml-1 red--text">(<v-icon @click.stop="goToRevisiPembimbing" class="red--text body-1 mx-1">mdi-file-download</v-icon>)</span></td>
															<td class="grey--text" v-if="files[0].status_dosen_pembimbing == 0">Proses Revisi</td>
															<td class="green--text" v-else-if="files[0].status_dosen_pembimbing == 1">Lolos</td>
															<td class="red--text" v-else-if="files[0].status_dosen_pembimbing == 2">Ditolak</td>
														</tr>
														<tr>
															<td>{{ revealKetuaPenguji(files[0].id_ketua_penguji) }} <span v-if="files[0].status_ketua_penguji == 2" class="ml-1 red--text">(<v-icon @click.stop="goToRevisiKetua" class="red--text body-1 mx-1">mdi-file-download</v-icon>)</span></td>
															<td class="grey--text" v-if="files[0].status_ketua_penguji == 0">Proses Revisi</td>
															<td class="green--text" v-else-if="files[0].status_ketua_penguji == 1">Lolos</td>
															<td class="red--text" v-else-if="files[0].status_ketua_penguji == 2">Ditolak</td>
														</tr>
														<tr>
															<td>{{ revealDosenPenguji(files[0].id_dosen_penguji) }} <span v-if="files[0].status_dosen_penguji == 2" class="ml-1 red--text">(<v-icon @click.stop="goToRevisiPenguji" class="red--text body-1 mx-1">mdi-file-download</v-icon>)</span></td></td>
															<td class="grey--text" v-if="files[0].status_dosen_penguji == 0">Proses Revisi</td>
															<td class="green--text" v-else-if="files[0].status_dosen_penguji == 1">Lolos</td>
															<td class="red--text" v-else-if="files[0].status_dosen_penguji == 2">Ditolak</td>
														</tr>
													</tbody>
												</template>
											</v-simple-table>
										</v-card-text>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="beritaAcara.length != 0">
                                    <v-card @click="viewBeritaAcaraDialog = !viewBeritaAcaraDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">BERITA ACARA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-note-multiple-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-note-text</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="viewBeritaAcaraDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Berita Acara</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-card-text>
											<v-simple-table class="mt-4">
												<template v-slot:default>
													<tbody>
														<tr>
															<td>Tanggal</td>
															<td>{{formatDate(beritaAcara[0].tanggal)}}</td>
														</tr>
														<tr>
															<td>Jam</td>
															<td>{{formatTime(beritaAcara[0].time)}}</td>
														</tr>
													</tbody>
												</template>
											</v-simple-table>
										</v-card-text>
									</v-card>
								</v-dialog>
							</v-row>
						</v-container>
					</v-layout>
					<v-snackbar
                        v-model="snackBar"
                        multi-line
                        v-bind:color="snackBarColor"
                    >
                        {{ snackBarMessage }}
                        <v-btn
                            text
                            @click="snackBar = false"
                        >
                            <v-icon>
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-snackbar>
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

				mounted() {
					this.get()
				},

				data() {
					return {
						snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
						uploadNewBerkasDialog: false,
						viewStatusBerkas: false,
						viewBeritaAcaraDialog: false,
						files: [],
						users: [],
						beritaAcara: [],
						file:'',
						test: '',
						fileRule: [
							v => !!v || 'File is required',
						]
					}
				},

				methods: {
					logOut() {
                        window.location.href = '<?=base_url('home/logOut');?>'
					},
					get() {
						return new Promise((resolve, reject) => {
							axios.get('<?= base_url()?>api/Berkas',{params: {id_mahasiswa: <?=$id?>}})
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject('Server Error')
								})
						})
						.then((response) => {
							this.files = response
						})
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/User')
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject('Server Error')
									})
							})
							.then((response) => {
								this.users = response
							})
						})
						.then(() => {
                            return new Promise((resolve, reject) => {
                                axios.get('<?= base_url()?>api/Berita_Acara',{params: {id: <?=$id?>}})
                                    .then(response => {
                                        resolve(response.data)
                                    }) .catch(err => {
                                        if(err.response.status == 500) reject('Server Error')
                                    })
                            })
                            .then((response) => {
                                this.beritaAcara = response
                            })
                        })
					},
					formatDate(item) {
						return item ? moment(item).format('DD MMMM YYYY') : ''
					},
                    formatTime(item) {
                        return item ? moment(item, 'h:mm:ss').format('LT') : ''
                    },
					revealDosenPembimbing(id) {
						return _.find(this.users,['id',id]).nama
					},
					revealKetuaPenguji(id) {
						return _.find(this.users,['id',id]).nama
					},
					revealDosenPenguji(id) {
						return _.find(this.users,['id',id]).nama
					},
					goToRevisiPembimbing() {
						window.location.href = this.files[0].revisi_dosen_pembimbing
					},
					goToRevisiKetua() {
						window.location.href = this.files[0].revisi_ketua_penguji
					},
					goToRevisiPenguji() {
						window.location.href = this.files[0].revisi_dosen_penguji
					},
					close() {
						if(this.uploadNewBerkasDialog) {
							this.uploadNewBerkasDialog = false
							this.file = ''
						} else {
							if(this.viewStatusBerkas) {
								this.viewStatusBerkas = false
							} else {
								if(this.viewBeritaAcaraDialog) {
									this.viewBeritaAcaraDialog = false
								}
							}
						}
					},
					uploadBerkasBaru() {
						if(this.$refs.form.validate()) {
							const data = new FormData()
							data.append('file',this.file)
							return new Promise((resolve, reject) => {
								axios.post('<?= base_url()?>api/Berkas',data,{headers: {'Content-Type': 'multipart/form-data'}})
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject('Server Error')
										if(err.response.status == 401) reject(err.response.data)
									})
							})
							.then((response) => {
								this.snackBarMessage = response.message
								this.snackBarColor = 'success'
							}) .catch(err => {
								if(err.message == "ONLY ACCEPT ZIP / RAR / DOC / DOCX / ZIP FILE TYPE") {
									this.snackBarMessage = err.message
									this.snackBarColor = 'warning'
                                } else {
                                    this.snackBarMessage = err
                                    this.snackBarColor = 'error'
                                    this.snackBar = true
                                }
							}) .finally(() => {
								this.snackBar = true
								this.close()
								this.get()
							})
						}
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
					},
				},

			})
		</script>
	</body>

</html>
