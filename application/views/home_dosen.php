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
                                    <v-card @click="listBimbinganDialog = !listBimbinganDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">MAHASISWA BIMBINGAN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-supervisor</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
                                <v-dialog v-model="listBimbinganDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                                    <v-card>
                                        <v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Mahasiswa Bimbingan</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
                                        <v-col cols="12">
                                            <v-text-field
                                                placeholder="Cari Nama Mahasiswa"
                                                :solo='true'
                                                :clearable='true'
                                                append-icon="mdi-magnify"
                                                class="font-regular font-weight-light mt-2 mb-n4"
                                                v-model="searchMahasiswaBimbingan"
                                            />
                                        </v-col>
                                        <v-data-table
                                        :headers='mahasiswaBimbinganHeader'
                                        :items='mahasiswaBimbingans'
                                        :mobile-breakpoint="1"
                                        @click:row="detailMahasiswaBimbingan"
                                        :search="searchMahasiswaBimbingan"
                                        >
                                            <template v-slot:item.nama="{ item }">
                                                {{item.nama}}
                                            </template>
                                            <template v-slot:item.berkas[0].file="{ item }">
                                                <v-icon v-if="item.berkas.length != 0" @click.stop="downloadBerkasMahasiswaBimbingan(item)" class="blue--text headline mx-1">mdi-file-download</v-icon>
                                                <v-icon v-else class="headline mx-1">mdi-file-remove</v-icon>
                                            </template>
                                            <template v-slot:item.berkas[0].status_dosen_pembimbing="{ item }">
                                                <div v-if="item.berkas.length != 0">
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 0">Belum Diperiksa</span>
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 1" class="green--text">Lolos</span>
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 2" class="red--text">Revisi</span>
                                                </div>
                                                <div v-else>
                                                    <span class="grey--text">Belum Upload Berkas</span>
                                                </div>
                                            </template>
                                        </v-data-table>
                                        <v-dialog v-model="detailBimbinganDialog" max-width="700px" style="z-index:999">
                                            <v-card>{{mahasiswaBimbingan}}</v-card>
                                        </v-dialog>
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
                        searchMahasiswaBimbingan: '',
                        listBimbinganDialog: false,
                        detailBimbinganDialog: false,
                        selectedIndex: -1,
                        mahasiswaBimbingans:[],
                        mahasiswaBimbingan: {},
						fileRule: [
							v => !!v || 'File is required',
						]
					}
				},

				methods: {
                    get() {
                        return new Promise((resolve, reject) => {
                            axios.get('<?= base_url()?>api/Berkas',{params: {id_dosen_pembimbing: <?=$id?>}})
                                .then(response => {
                                    resolve(response.data)
                                }) .catch(err => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
                        })
                        .then((response) => {
                            this.mahasiswaBimbingans = response
                        })
                    },
                    downloadBerkasMahasiswaBimbingan(item) {
                        window.location.href = item.berkas[0].file
                    },
					logOut() {
                        window.location.href = '<?=base_url('home/logOut');?>'
                    },
                    close() {
                        if(this.listBimbinganDialog) {
                            this.listBimbinganDialog = false
                        }
                    },
                    detailMahasiswaBimbingan(item) {
                        this.selectedIndex = this.mahasiswaBimbingans.indexOf(item)
                        this.mahasiswaBimbingan = Object.assign({},item)
                        this.detailBimbinganDialog = true
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
                    mahasiswaBimbinganHeader() {
                        return [
                            {text:'Nama', value:'nama'},
                            {text:'Berkas', value:'berkas[0].file', width:'10%'},
                            {text:'Status Revisi', value:'berkas[0].status_dosen_pembimbing', width:'20%'},
                        ]
                    }
				},

			})
		</script>
	</body>

</html>
