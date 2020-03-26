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
                                        style="cursor:pointer"
                                        >
                                            <template v-slot:item.nama="{ item }">
                                                {{item.nama}}
                                            </template>
                                            <template v-slot:item.berkas[0].file="{ item }">
                                                <v-icon v-if="item.berkas.length != 0" @click.stop="downloadBerkasMahasiswaBimbingan(item)" class="blue--text headline mx-1">mdi-file-download</v-icon>
                                                <v-icon v-else class="headline mx-1 grey--text">mdi-file-remove</v-icon>
                                            </template>
                                            <template v-slot:item.berkas[0].status_dosen_pembimbing="{ item }">
                                                <div v-if="item.berkas.length != 0">
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 0">Belum Diperiksa</span>
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 1" class="green--text">Lolos</span>
                                                        <span v-if="item.berkas[0].status_dosen_pembimbing == 2" class="red--text">Revisi</span>
                                                </div>
                                                <div v-else>
                                                    <span class="grey--text">-</span>
                                                </div>
                                            </template>
                                        </v-data-table>
                                        <v-dialog v-model="detailBimbinganDialog" max-width="700px" style="z-index:999">
                                            <v-card>
                                                <v-toolbar dense flat color="blue">
                                                    <span class="title font-weight-light">Upload Revisi</span>
                                                    <v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                                                </v-toolbar>
                                                <v-card-text>
                                                    <v-row align="center" justify="center">
                                                        <v-col cols="12">
                                                            <v-select
                                                                :items="statusList"
                                                                v-model="status"
                                                                label="Status"
                                                                class="mb-n2"
                                                                item-text="value"
                                                                item-value="id"
                                                            >
                                                        </v-col>
                                                        <v-col cols="12">
                                                            <v-form ref="form">
                                                                <v-file-input
                                                                    class="mt-4 mb-n4"
                                                                    v-model="file"
                                                                    color="blue"
                                                                    label="File Input"
                                                                    placeholder="Select your File"
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
                                                        <v-btn class="mt-n8" color="green white--text" @click="revisiBerkasDosenPembimbing">Upload</v-btn>
                                                    </v-row>
                                                </v-container>
                                            </v-card-actions>
                                            </v-card>
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
                        file:'',
                        status:'',
                        statusList: [
                            {id:1, value:'Lolos'},
                            {id:2, value:'Revisi'}
                        ],
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
                        if(this.listBimbinganDialog && !this.detailBimbinganDialog) {
                            this.listBimbinganDialog = false
                        } else {
                            if(this.detailBimbinganDialog) {
                                this.detailBimbinganDialog = false
                            }
                        }
                    },
                    detailMahasiswaBimbingan(item) {
                        this.selectedIndex = this.mahasiswaBimbingans.indexOf(item)
                        this.mahasiswaBimbingan = Object.assign({},item)
                        this.detailBimbinganDialog = true
                    },
                    revisiBerkasDosenPembimbing() {
                        return new Promise((resolve, reject) => {
                            const data = new FormData()
                            data.append('id',this.mahasiswaBimbingan.berkas[0].id)
                            data.append('id_mahasiswa',this.mahasiswaBimbingan.id)
                            data.append('id_dosen_pembimbing',this.mahasiswaBimbingan.id_dosen_pembimbing)
                            data.append('id_ketua_penguji',this.mahasiswaBimbingan.id_ketua_penguji)
                            data.append('id_dosen_penguji',this.mahasiswaBimbingan.id_dosen_penguji)
                            data.append('file_mahasiswa',this.mahasiswaBimbingan.berkas[0].file)
                            data.append('file',this.file)
                            data.append('status_ketua_penguji',this.mahasiswaBimbingan.berkas[0].status_ketua_penguji)
                            data.append('status_dosen_penguji',this.mahasiswaBimbingan.berkas[0].status_dosen_penguji)
                            axios.post(
                                '<?= base_url()?>api/UploadRevisi',
                                data,
                                {headers: {'Content-Type': 'multipart/form-data'}}
                            )
                                .then((response) => {
                                    resolve(response.data)
                                }) .catch(err => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
                        })
                        .then((response) => {
                            this.snackBarMessage = response.message
                            this.snackBarColor = 'success'
                        }) .catch(err => {
                            this.snackBarMessage = err
                            this.snackBarColor = 'error'
                            this.snackBar = true
                        }) .finally(() => {
                            this.snackBar = true
                            this.close()
                            this.get()
                        })
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
