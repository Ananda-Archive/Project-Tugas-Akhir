<v-app-bar app dark clipped-left>
    <span v-if="!popUpBreakPoint">Informatika Universitas Diponegoro</span>
    <span v-else class="body-2 font-weight-thin">Informatika Universitas Diponegoro</span>
    <v-spacer></v-spacer>
    <span v-if="!popUpBreakPoint" class="body-1 mr-4"><?=$nama?></span>
    <div>
        <v-avatar color="#2196F3" disabled><span class="white--text subtitle"><?=$nama[0]?></span></v-avatar>
        <span class="text-center">
            <v-menu open-on-hover bottom offset-y transition="slide-y-transition" :close-on-content-click="false">
                <template v-slot:activator="{ on }">
                    <span v-on="on"><v-icon>mdi-chevron-down</v-icon></span>
                </template>
                <v-list>
                    <v-list-item v-if="popUpBreakPoint">
                        <v-list-item-content><?=$nama?></v-list-item-content>
                    </v-list-item>
                    <v-divider v-if="popUpBreakPoint"></v-divider>
                    <v-list-item @click="">
                        <v-list-item-icon  class="mr-2"><v-icon>mdi-account</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Profil Saya</v-list-item-title></v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="logOut">
                        <v-list-item-icon class="mr-2"><v-icon color="red">mdi-power</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title class="red--text">Keluar</v-list-item-title></v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </span>
    </div>
</v-app-bar>