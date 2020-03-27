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
                            <v-row align="center">
								<v-col cols="12" sm="12" md="3" v-if="<?=$role?>==2">
                                    <v-card @click="createNewUserDialog = !createNewUserDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">CREATE NEW USER</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-account</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-plus</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="createNewUserDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Create New User</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="form" class="px-2">
											<v-card-text>
												<v-row>
													<v-col cols="12">
														<v-text-field class="mb-n4" color="blue" label="NIP / NIM" v-model="user.nomor" :rules="rules.nomor"/>
													</v-col>
													<v-col cols="12">
														<v-text-field class="mb-n4" color="blue" label="Nama" v-model="user.nama" :rules="rules.nama"/>
													</v-col>
													<v-col cols="12">
														<v-select
															:items="listRole"
															v-model="user.role"
															label="Status"
															class="mb-n2"
															item-text="value"
															item-value="id"
														>
														</v-select>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="user.id_dosen_pembimbing"
															:items="listDosen"
															label="Dosen Pembimbing"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="dosenPembimbingInput"
															@change="dosenPembimbingInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_dosen_pembimbing != null"
															@click:clear="user.id_dosen_pembimbing = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="user.id_ketua_penguji"
															:items="listDosen"
															label="Ketua Dosen Penguji"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="ketuaDosenPengujiInput"
															@change="ketuaDosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_ketua_penguji != null"
															@click:clear="user.id_ketua_penguji = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
														<v-autocomplete
															v-if="user.role == 0"
															v-model="user.id_dosen_penguji"
															:items="listDosen"
															label="Dosen Penguji 1"
															chips
															dense
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="dosenPengujiInput"
															@change="dosenPengujiInput=''"
															item-text="nama"
															item-value="id"
															:readonly="user.id_dosen_penguji != null"
															@click:clear="user.id_dosen_penguji = null"
															class="mb-n2"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nama}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
												</v-row>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="createNewUser">Create</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="<?=$role?>==2">
                                    <v-card @click="listMahasiswaDialog = !listMahasiswaDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST MAHASISWA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-group-outline</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listMahasiswaDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Mahasiswa</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-col cols="12">
											<v-text-field
												placeholder="Cari Mahasiswa"
												:solo='true'
												:clearable='true'
												append-icon="mdi-magnify"
												class="font-regular font-weight-light mt-2 mb-n4"
												v-model="searchMahasiswa"
											/>
										</v-col>
										<v-data-table
											:headers='mahasiswaHeader'
											:items='users'
											v-if="!popUpBreakPoint"
											item-key="nama"
											:search="searchMahasiswa"
										>
											<template class="pl-n4" v-slot:item.id_dosen_pembimbing="{ item }">
												<span v-if="item.id_dosen_pembimbing != null">{{ revealDosenPembimbing(item.id_dosen_pembimbing) }}</span>
											</template>
											<template class="pl-n4" v-slot:item.id_ketua_penguji="{ item }">
												<span v-if="item.id_ketua_penguji != null">{{ revealDosenPembimbing(item.id_ketua_penguji) }}</span>
											</template>
											<template class="pl-n4" v-slot:item.id_dosen_penguji="{ item }">
												<span v-if="item.id_dosen_penguji != null">{{ revealDosenPembimbing(item.id_dosen_penguji) }}</span>
											</template>
											<template v-slot:item.actions="{ item }">
												<v-icon class="mr-2" @click.stop="editMahasiswa(item)">mdi-pencil</v-icon>
												<v-icon class="mr-2" @click.stop="confirmDeleteUser(item)">mdi-delete</v-icon>
											</template>
										</v-data-table>
										<v-data-table
											:headers='mahasiswaHeader'
											:items='users'
											v-else
											item-key="nama"
											:search="searchMahasiswa"
											:disable-sort="true"
											class="mt-n10"
										>
											<template v-slot:item="{ item }">
												<v-card class="mt-1 mb-3 mx-2 pa-2" outlined>
													<div class="d-flex flex-no-wrap justify-space-between align-center">
														<div>
															<v-card-title class="body-2 mt-n2">{{ item.nama }}</v-card-title>
														</div>
														<div class="mt-n2 mr-n2">
															<v-menu
																:close-on-click="true"
																:close-on-content-click="true"
																:offset-y="true"
															>
																<template v-slot:activator="{ on }">
																	<v-card-actions><v-icon v-on="on">mdi-dots-vertical</v-icon></v-card-actions>
																</template>
																<v-list>
																	<v-list-item @click.stop="editMahasiswa(item)">
																		<v-list-item-title>Edit</v-list-item-title>
																	</v-list-item>
																	<v-list-item @click.stop="confirmDeleteUser(item)">
																		<v-list-item-title>Hapus</v-list-item-title>
																	</v-list-item>
																</v-list>
															</v-menu>
														</div>
													</div>
													<v-divider></v-divider>
													<v-list-item two-line>
														<v-list-item-content>
															<v-list-item-title>Dosen Pembimbing</v-list-item-title>
															<v-list-item-subtitle v-if="item.id_dosen_pembimbing != null">{{ revealDosenPembimbing(item.id_dosen_pembimbing) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
													<v-list-item two-line class="mt-n2">
														<v-list-item-content>
															<v-list-item-title>Ketua Dosen Penguji</v-list-item-title>
															<v-list-item-subtitle v-if="item.id_ketua_penguji != null">{{ revealKetuaPenguji(item.id_ketua_penguji) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
													<v-list-item two-line class="mt-n2">
														<v-list-item-content>
															<v-list-item-title>Dosen Penguji 1</v-list-item-title>
															<v-list-item-subtitle v-if="item.id_dosen_penguji != null">{{ revealDosenPenguji(item.id_dosen_penguji) }}</v-list-item-subtitle>
														</v-list-item-content>
													</v-list-item>
												</v-card>
											</template>
										</v-data-table>
									</v-card>
									<!-- Delete User -->
									<v-dialog style="z-index:999" v-model="confirmDeleteUserDialog" persistent max-width="500px">
										<v-card>
											<v-card-title>Konfirmasi</v-card-title>
											<v-card-text>Apakah Anda Yakin Ingin Menghapus {{editField.nama}}?</v-card-text>
											<v-card-actions>
												<v-container>
													<v-row justify="center">
														<v-btn class="mt-n5" color="red darken-1" text @click="confirmDeleteUserDialog = false">Tidak</v-btn>
														<v-btn class="mt-n5" color="blue darken-1" text @click="deleteUser">Ya</v-btn>
													</v-row>
												</v-container>
											</v-card-actions>
										</v-card>
									</v-dialog>
									<!-- EDIT USER -->
									<v-dialog v-model="editMahasiswaDialog" persistent max-width="700px">
										<v-card>
											<v-toolbar dense flat color="blue">
												<span class="title font-weight-light">Edit User</span>
												<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
											</v-toolbar>
											<v-form ref="form" class="px-2">
												<v-card-text>
													<v-row>
														<v-row justify="end" class="pr-4">
															<v-chip @click="changePasswordDefaultDialog = !changePasswordDefaultDialog" label dense class="mb-n4 pa-n4" color="transparent orange--text">Klik Disini Untuk Reset Password</v-chip>
														</v-row>
														<v-col cols="12">
															<v-text-field class="mb-n4" color="blue" label="NIP / NIM" v-model="editField.nomor" :rules="rules.nomor"/>
														</v-col>
														<v-col cols="12">
															<v-text-field class="mb-n4" color="blue" label="Nama" v-model="editField.nama" :rules="rules.nama"/>
														</v-col>
														<v-col cols="12">
															<v-select
																:items="listRole"
																v-model="editField.role"
																label="Status"
																class="mb-n2"
																item-text="value"
																item-value="id"
															>
															</v-select>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_dosen_pembimbing"
																:items="listDosen"
																label="Dosen Pembimbing"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="dosenPembimbingInput"
																@change="dosenPembimbingInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_dosen_pembimbing != null"
																@click:clear="editField.id_dosen_pembimbing = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_ketua_penguji"
																:items="listDosen"
																label="Ketua Dosen Penguji"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="ketuaDosenPengujiInput"
																@change="ketuaDosenPengujiInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_ketua_penguji != null"
																@click:clear="editField.id_ketua_penguji = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_dosen_penguji"
																:items="listDosen"
																label="Dosen Penguji 1"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="dosenPengujiInput"
																@change="dosenPengujiInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_dosen_penguji != null"
																@click:clear="editField.id_dosen_penguji = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
													</v-row>
												</v-card-text>
											</v-form>
											<v-card-actions>
												<v-container>
													<v-row justify="center">
														<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
														<v-btn class="mt-n8" color="green white--text" @click="updateUser">Update</v-btn>
													</v-row>
												</v-container>
											</v-card-actions>
										</v-card>
									</v-dialog>
									<!--  -->
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="<?=$role?>==2">
                                    <v-card @click="listDosenDialog = !listDosenDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST DOSEN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-numbered</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-teach</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listDosenDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Dosen</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-col cols="12">
											<v-text-field
												placeholder="Cari Dosen"
												:solo='true'
												:clearable='true'
												append-icon="mdi-magnify"
												class="font-regular font-weight-light mt-2 mb-n4"
												v-model="searchDosen"
											/>
										</v-col>
										<v-data-table
											:headers='dosenHeader'
											:items='users'
											:mobile-breakpoint="1"
											:search="searchDosen"
										>
											<template v-slot:item.actions="{ item }">
												<v-icon class="mr-2" @click.stop="editDosen(item)">mdi-pencil</v-icon>
												<v-icon class="mr-2" @click.stop="confirmDeleteUser(item)">mdi-delete</v-icon>
											</template>
										</v-data-table>
									</v-card>
									<!-- Delete User -->
									<v-dialog style="z-index:999" v-model="confirmDeleteUserDialog" persistent max-width="500px">
										<v-card>
											<v-card-title>Konfirmasi</v-card-title>
											<v-card-text>Apakah Anda Yakin Ingin Menghapus {{editField.nama}}?</v-card-text>
											<v-card-actions>
												<v-container>
													<v-row justify="center">
														<v-btn class="mt-n5" color="red darken-1" text @click="confirmDeleteUserDialog = false">Tidak</v-btn>
														<v-btn class="mt-n5" color="blue darken-1" text @click="deleteUser">Ya</v-btn>
													</v-row>
												</v-container>
											</v-card-actions>
										</v-card>
									</v-dialog>
									<!-- EDIT USER -->
									<v-dialog v-model="editDosenDialog" persistent max-width="700px">
										<v-card>
											<v-toolbar dense flat color="blue">
												<span class="title font-weight-light">Edit User</span>
												<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
											</v-toolbar>
											<v-form ref="form" class="px-2">
												<v-card-text>
													<v-row>
														<v-row justify="end" class="pr-4">
															<v-chip @click="changePasswordDefaultDialog = !changePasswordDefaultDialog" label dense class="mb-n4 pa-n4" color="transparent orange--text">Klik Disini Untuk Reset Password</v-chip>
														</v-row>
														<v-col cols="12">
															<v-text-field class="mb-n4" color="blue" label="NIP / NIM" v-model="editField.nomor" :rules="rules.nomor"/>
														</v-col>
														<v-col cols="12">
															<v-text-field class="mb-n4" color="blue" label="Nama" v-model="editField.nama" :rules="rules.nama"/>
														</v-col>
														<v-col cols="12">
															<v-select
																:items="listRole"
																v-model="editField.role"
																label="Status"
																class="mb-n2"
																item-text="value"
																item-value="id"
															>
															</v-select>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_dosen_pembimbing"
																:items="listDosen"
																label="Dosen Pembimbing"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="dosenPembimbingInput"
																@change="dosenPembimbingInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_dosen_pembimbing != null"
																@click:clear="editField.id_dosen_pembimbing = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_ketua_penguji"
																:items="listDosen"
																label="Ketua Dosen Penguji"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="ketuaDosenPengujiInput"
																@change="ketuaDosenPengujiInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_ketua_penguji != null"
																@click:clear="editField.id_ketua_penguji = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
														<v-col cols="12">
															<v-autocomplete
																v-if="+editField.role == 0"
																v-model="editField.id_dosen_penguji"
																:items="listDosen"
																label="Dosen Penguji 1"
																chips
																dense
																:clearable="true"
																:auto-select-first="true"
																color="blue"
																item-color="blue"
																:search-input.sync="dosenPengujiInput"
																@change="dosenPengujiInput=''"
																item-text="nama"
																item-value="id"
																:readonly="editField.id_dosen_penguji != null"
																@click:clear="editField.id_dosen_penguji = null"
																class="mb-n2"
															>
															<template v-slot:selection="data">
																<v-chip color="transparent" class="pa-0">
																	{{data.item.nama}}
																</v-chip>
															</template>
															</v-autocomplete>
														</v-col>
													</v-row>
												</v-card-text>
											</v-form>
											<v-card-actions>
												<v-container>
													<v-row justify="center">
														<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
														<v-btn class="mt-n8" color="green white--text" @click="updateUser">Update</v-btn>
													</v-row>
												</v-container>
											</v-card-actions>
										</v-card>
									</v-dialog>
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="<?=$role?>==2">
                                    <v-card @click="createBeritaAcaraDialog = !createBeritaAcaraDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">BUAT BERITA ACARA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-note-multiple-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-note-plus-outline</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="createBeritaAcaraDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Buat Berita Acara</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="form" class="px-2">
											<v-card-text>
												<v-row>
													<v-col cols="12">
														<v-autocomplete
															v-model="beritaAcara.id_mahasiswa"
															:items="listMahasiswaReady"
															label="NIM"
															chips
															dense
															:solo="true"
															:clearable="true"
                                                    		:auto-select-first="true"
															color="blue"
															item-color="blue"
															:search-input.sync="mahasiswaInput"
															@change="mahasiswaInput=''"
															item-text="nomor"
															item-value="id"
															:readonly="beritaAcara.id_mahasiswa != null"
															@click:clear="beritaAcara.id_mahasiswa = null"
															class="mb-n4"
															:rules="rules.nomor"
														>
														<template v-slot:selection="data">
															<v-chip color="transparent" class="pa-0">
																{{data.item.nomor}}
															</v-chip>
														</template>
														</v-autocomplete>
													</v-col>
													<v-col cols="12">
													<v-menu
														ref="showDatePicker"
														v-model="showDatePicker"
														:close-on-content-click="false"
														transition="scale-transition"
														offset-y
														min-width="290px"
													>
														<template v-slot:activator="{ on }">
															<v-text-field
															color="accent"
															label="Tanggal"
															append-icon="mdi-calendar"
															:value="formatDate"
															readonly
															v-on="on"
															:solo="true"
															:clearable="true"
															@click:clear="beritaAcara.tanggal = null"
															dense
															class="mb-n4"
															:rules="rules.date"
															></v-text-field>
														</template>
														<v-date-picker v-model="beritaAcara.tanggal"  no-title scrollable :weekday-format="dayFormat" @change="showDatePicker = false">
														</v-date-picker>
													</v-menu>
													</v-col>
													<v-col cols="12">
														<v-dialog
															ref="dialog"
															v-model="showTimePicker"
															:return-value.sync="beritaAcara.time"
															persistent
															width="290px"
															style="z-index:9999"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																:solo="true"
																dense
																v-model="beritaAcara.time"
																label="Waktu"
																append-icon="mdi-clock-outline"
																readonly
																v-on="on"
																:clearable="true"
																@click:clear="beritaAcara.time = ''"
																:rules="rules.time"
																></v-text-field>
															</template>
															<v-time-picker
																v-if="showTimePicker"
																v-model="beritaAcara.time"
																full-width
															>
															<v-spacer></v-spacer>
																<v-btn text color="primary" @click="showTimePicker = false">Cancel</v-btn>
																<v-btn text color="primary" @click="$refs.dialog.save(beritaAcara.time)">OK</v-btn>
															</v-time-picker>
														</dialog>
													</v-col>
												</v-row>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="createNewBeritaAcara">Create</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3" v-if="<?=$role?>==2">
                                    <v-card @click="listBeritaAcaraDialog = !listBeritaAcaraDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST BERITA ACARA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-note-multiple-outline</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-note-text</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listBeritaAcaraDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">List Dosen</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-col cols="12">
											<v-text-field
												placeholder="Cari Nama Mahasiswa / NIM"
												:solo='true'
												:clearable='true'
												append-icon="mdi-magnify"
												class="font-regular font-weight-light mt-2 mb-n4"
												v-model="searchBeritaAcara"
											/>
										</v-col>
										<v-data-table
											:headers='beritaAcaraHeader'
											:items='beritaAcaras'
											:mobile-breakpoint="1"
											:search="searchBeritaAcara"
										>
											<template v-slot:item.tanggal="{ item }">
												<div v-if="item.length != 0">
													<span>{{formatDates(item.tanggal)}}</span>
												</div>
											</template>
											<template v-slot:item.time="{ item }">
												<div v-if="item.length != 0">
													<span>{{formatTime(item.time)}}</span>
												</div>
											</template>
										</v-data-table>
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
					<!-- change Password default -->
					<v-dialog style="z-index:999" v-model="changePasswordDefaultDialog" persistent max-width="500px">
						<v-card>
							<v-card-title>Konfirmasi</v-card-title>
							<v-card-text>Apakah Anda Yakin Ingin Reset Password {{editField.nama}}?</v-card-text>
							<v-card-actions>
								<v-container>
									<v-row justify="center">
										<v-btn class="mt-n5" color="red darken-1" text @click="changePasswordDefaultDialog = false">Tidak</v-btn>
										<v-btn class="mt-n5" color="blue darken-1" text @click="changePasswordDefault">Ya</v-btn>
									</v-row>
								</v-container>
							</v-card-actions>
						</v-card>
					</v-dialog>
					<!-- Change Password Pop Up -->
					<v-dialog v-model="changePasswordDialog" max-width="600px" persistent>
						<v-toolbar dense flat color="blue">
							<span class="title font-weight-light">Ganti Password</span>
							<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
						</v-toolbar>
						<v-form ref="form" class="px-2">
							<v-card-text>
							<v-row>
								<v-col cols="12">
									<v-text-field
										v-model="passwordAfter"
										label="Password Baru"
										:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
										:type="showPassword ? 'text' : 'password'"
										@click:append="showPassword = !showPassword"
										:rules='rules.passwordAfter'
									></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field
										v-model="passwordAfterConfirmation"
										label="Konfirmasi Password"
										:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
										:type="showPassword ? 'text' : 'password'"
										@click:append="showPassword = !showPassword"
										:rules='rules.passwordConfirm'
									></v-text-field>
								</v-col>
							</v-row>
							</v-card-text>
						</v-form>
						<v-card-actions>
							<v-container>
								<v-row justify="center">
									<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
									<v-btn class="mt-n8" color="green white--text" @click="changePassword">Change Password</v-btn>
								</v-row>
							</v-container>
						</v-card-actions>
					</v-dialog>
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
						profileImage:'',
						createNewUserDialog: false,
						listMahasiswaDialog: false,
						listDosenDialog: false,
						listBeritaAcaraDialog: false,
						createBeritaAcaraDialog: false,
						showDatePicker: false,
						showTimePicker: false,
						users: [],
						listDosen: [],
						listMahasiswa: [],
						listMahasiswaReady: [],
						beritaAcaras: [],
						user: {
							id:null,
							nomor:'',
							nama:'',
							role:'',
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						userDefault: {
							id:null,
							nomor:'',
							nama:'',
							role:'',
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						editField: {
							id:null,
							nomor:'',
							nama:'',
							password:'',
							role:null,
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						editFieldDefault: {
							id:null,
							nomor:'',
							nama:'',
							password:'',
							role:null,
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						password: null,
						beritaAcara: {
							tanggal:'',
							time:'',
							id_mahasiswa:null
						},
						beritaAcaraDefault: {
							tanggal:'',
							time:'',
							id_mahasiswa:null
						},
						dosenPembimbingInput:'',
						searchMahasiswa:'',
						searchDosen:'',
						searchBeritaAcara:'',
						ketuaDosenPengujiInput:'',
						dosenPengujiInput:'',
						mahasiswaInput:'',
						listRole: [
							{id:'0', value:'Mahasiswa'},
							{id:'1', value:'Dosen'},
							{id:'2', value:'Admin'}
						],
						rules: {
							nomor: [
								v => !!v || 'NIP / NIM Wajib diisi',
                                v => /^[0-9]*$/.test(v) || 'NIP / NIM Harus berupa angka'
							],
							nama: [
								v => !!v || 'Nama Wajib diisi',
							],
							date: [
								v => !!v || 'Tanggal Wajib Diisi',
							],
							time: [
								v => !!v || 'Jam Wajib diisi',
							],
                            password: [
                                v => !!v || 'Password Wajib diisi',
                                v => v.length>=8 || 'Minimal 8 Karakter',
                            ],
							passwordAfter: [
								v => !!v || 'Password Wajib diisi',
                                v => v == this.passwordAfter || 'Password Konfirmasi Harus Sama Dengan Password Baru',
								v => v.length>=8 || 'Minimal 8 Karakter',
							],
							passwordConfirm: [
								v => !!v || 'Password Wajib diisi',
                                v => v == this.passwordAfter || 'Password Konfirmasi Harus Sama Dengan Password Baru',
							]
						},
						snackBar: false,
                        snackBarColor: '',
                        snackBarMessage: '',
						selectedIndex: -1,
						editMahasiswaDialog: false,
						editDosenDialog: false,
						confirmDeleteUserDialog: false,
						showPassword: false,
						changePasswordDialog: false,
						changePasswordDefaultDialog: false,
						passwordAfter:'',
						passwordAfterConfirmation:''
					}
				},

				methods: {
					changePasswordOpenDialog() {
						this.changePasswordDialog = true
					},
					changePasswordDefault() {
						return new Promise((resolve, reject) => {
							let data = {
								id: this.editField.id,
								nomor: this.editField.nomor
							}
							axios.put('<?= base_url()?>api/Password', data)
							.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
									})
						})
						.then((response) => {
							this.snackBarMessage = response.message
							this.snackBarColor = 'success'
						}) .catch(err => {
							this.snackBarMessage = err.message
							this.snackBarColor = 'error'
							this.snackBar = true
						}) .finally(() => {
							this.snackBar = true
							this.get()
							this.changePasswordDefaultDialog = false
						})
					},
					changePassword() {
						if(this.$refs.form.validate()) {
							return new Promise((resolve, reject) => {
								let data = {
									id: <?=$id?>,
									password: this.passwordAfter
								}
								axios.put('<?= base_url()?>api/Password', data)
								.then(response => {
											resolve(response.data)
										}) .catch(err => {
											if(err.response.status == 500) reject(err.response.data)
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
								this.get()
								this.close()
							})
						}
					},
					editMahasiswa(item) {
						this.selectedIndex = this.users.indexOf(item)
						this.editField = Object.assign({},item)
						this.editMahasiswaDialog = true
					},
					editDosen(item) {
						this.selectedIndex = this.users.indexOf(item)
						this.editField = Object.assign({},item)
						this.editDosenDialog = true
					},
					confirmDeleteUser(item) {
						this.selectedIndex = this.users.indexOf(item)
						this.editField = Object.assign({},item)
						this.confirmDeleteUserDialog = true
					},
					deleteUser() {
						return new Promise((resolve, reject) => {
							axios.delete('<?= base_url()?>api/User', {params: {id: this.editField.id}})
								.then(() => {
									resolve('Delete Success')
								}) .catch((err) => {
									if(error.response.status == 500) reject(serverErrorMessage)
								})
						})
						.then((response) => {
							this.snackBarMessage = response
							this.snackBarColor = 'success'
						}) .catch(err => {
							this.snackBarMessage = err
							this.snackBarColor = 'error'
							this.snackBar = true
						}) .finally(() => {
							this.snackBar = true
							this.get()
							this.editField = Object.assign({},this.editFieldDefault)
							this.close()
						})
					},
                    logOut() {
                        window.location.href = '<?=base_url('home/logOut');?>'
                    },
                    formatDates(item) {
						return item ? moment(item).format('DD MMMM YYYY') : ''
					},
                    formatTime(item) {
                        return item ? moment(item, 'h:mm:ss').format('LT') : ''
                    },
					get() {
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
							response.forEach(user => {
								if(user.role == 0) {
									this.listMahasiswa.push(user)
									if(user.berkas.length > 0) {
										this.listMahasiswaReady.push(user)
									}
								} else {
									if(user.role == 1) {
										this.listDosen.push(user)
									}
								}
							})
							
						})
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/Berita_Acara')
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject('Server Error')
									})
							})
							.then((response) => {
								this.beritaAcaras = response
							})
						})
					},
					updateUser() {
						if(this.$refs.form.validate()) {
							if(this.editField.role != '0') {
								this.editField.id_dosen_pembimbing = null
								this.editField.id_ketua_penguji = null
								this.editField.id_dosen_penguji = null
							}
							return new Promise((resolve, reject) => {
								let data = {
									id:this.editField.id,
									nomor:this.editField.nomor,
									nama:this.editField.nama,
									role:this.editField.role,
									id_dosen_pembimbing:this.editField.id_dosen_pembimbing,
									id_ketua_penguji:this.editField.id_ketua_penguji,
									id_dosen_penguji:this.editField.id_dosen_penguji
								}
								axios.put('<?= base_url()?>api/User',this.editField)
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
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
								this.get()
								this.editField = Object.assign({},this.editFieldDefault)
								this.close()
							})
						}
					},
					createNewUser() {
						if(this.$refs.form.validate()) {
							if(this.user.role != '0') {
								this.user.id_dosen_pembimbing = null
								this.user.id_ketua_penguji = null
								this.user.id_dosen_penguji = null
							}
							return new Promise((resolve, reject) => {
								axios.post('<?= base_url()?>api/User',this.user)
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
										if(err.response.status == 401) reject(err.response.data)
									})
							})
							.then((response) => {
								this.snackBarMessage = response.message
								this.snackBarColor = 'success'
							}) .catch(err => {
								if(err.message == "NIM / NIP already exists.") {
									this.snackBarMessage = err.message
									this.snackBarColor = 'warning'
								} else {
									this.snackBarMessage = err
									this.snackBarColor = 'error'
									this.snackBar = true
								}
							}) .finally(() => {
								this.snackBar = true
								this.get()
								this.user = Object.assign({},this.userDefault)
								this.close()
							})
						}
					},
					createNewBeritaAcara() {
						if(this.$refs.form.validate()) {
							return new Promise((resolve, reject) => {
								axios.post('<?= base_url()?>api/Berita_Acara',this.beritaAcara)
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
								this.snackBarMessage = err
								this.snackBarColor = 'error'
								this.snackBar = true
							}) .finally(() => {
								this.snackBar = true
								this.get()
								this.beritaAcara = Object.assign({},this.beritaAcaraDefault)
								this.close()
							})
						}
					},
					close() {
						if(this.createNewUserDialog) {
							this.createNewUserDialog = false
							this.user = Object.assign({},this.userDefault)
						} else {
							if(this.listMahasiswaDialog && !this.editMahasiswaDialog && !this.confirmDeleteUserDialog) {
								this.listMahasiswaDialog = false
								this.searchMahasiswa = ''
							} else {
								if(this.listDosenDialog && !this.editDosenDialog && !this.confirmDeleteUserDialog) {
									this.listDosenDialog = false
									this.searchDosen = ''
								} else {
									if(this.createBeritaAcaraDialog) {
										this.createBeritaAcaraDialog = false
										this.beritaAcara = Object.assign({},this.beritaAcaraDefault)
									} else {
										if(this.listBeritaAcaraDialog) {
											this.listBeritaAcaraDialog = false
											this.searchBeritaAcara = ''
										} else {
											if(this.editMahasiswaDialog || this.confirmDeleteUserDialog) {
												this.editMahasiswaDialog = false
												this.editField = Object.assign({},this.editFieldDefault)
											} else {
												if(this.changePasswordDialog) {
													this.changePasswordDialog = false
													this.passwordAfter=''
													this.passwordAfterConfirmation=''
												} else {
													if(this.editDosenDialog) {
														this.editDosenDialog = false
														this.editField = Object.assign({},this.editFieldDefault)
													}
												}
											}
										}
									}
								}
							}
						}
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
					dayFormat(date) {
						let i = new Date(date).getDay(date)
						var dayOftheWeek = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']
						return dayOftheWeek[i]
					},
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
					mahasiswaHeader() {
						return [
							{text:'Nama', value:'nama'},
							{value:'role', align: ' d-none', filter: value => {return value == 0}},
							{text:'Dosen Pembimbing', value:'id_dosen_pembimbing', filter: () => true},
							{text:'Ketua Dosen Penguji', value:'id_ketua_penguji', filter: () => true},
							{text:'Dosen Penguji 1', value:'id_dosen_penguji', filter: () => true},
							{value:'actions', filter:() => true}
						]
					},
					dosenHeader() {
						return [
							{text:'Nama', value:'nama'},
							{value:'role', align: ' d-none', filter: value => {return value == 1}},
							{value:'actions', filter:() => true}
						]
					},
					beritaAcaraHeader() {
						return [
							{text:'NIM', value:'mahasiswa[0].nomor'},
							{text:'Nama', value:'mahasiswa[0].nama'},
							{text:'Tanggal', value:'tanggal', filter: () => true},
							{text:'Jam', value:'time', filter: () => true},
							{value:'actions', filter:() => true}
						]
					},
					formatDate() {
						return this.beritaAcara.tanggal ? moment(this.beritaAcara.tanggal).format('DD MMMM YYYY') : ''
					},
				},

				watch: {
					createNewUserDialog() {
						this.$refs.form.resetValidation()
					},
					createBeritaAcaraDialog() {
						this.$refs.form.resetValidation()
					}
					
				}

			})
		</script>
	</body>

</html>
