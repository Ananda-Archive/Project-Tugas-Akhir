<v-app-bar app dark clipped-left>
    <v-app-bar-title>Informatika Universitas Diponegoro</v-app-bar-title>
    <v-spacer></v-spacer>
    <div v-if="profileImage != ''">
        <v-avatar :img="profileImage" disabled>
        <span class="text-center">
            <v-menu open-on-hover bottom offset-y transition="slide-y-transition" :close-on-content-click="false">
                <template v-slot:activator="{ on }">
                    <span v-on="on"><v-icon>mdi-chevron-down</v-icon></span>
                </template>
                <v-list>
                    <v-list-item @click="">
                        <v-list-item-icon  class="mr-2"><v-icon>mdi-account</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Profil Saya</v-list-item-title></v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="">
                        <v-list-item-icon class="mr-2"><v-icon color="red">mdi-power</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title class="red--text">Keluar</v-list-item-title></v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </span>
    </div>
    <div v-else>
        <v-avatar color="#2196F3" disabled><span class="white--text subtitle">?</span></v-avatar>
        <span class="text-center">
            <v-menu open-on-hover bottom offset-y transition="slide-y-transition" :close-on-content-click="false">
                <template v-slot:activator="{ on }">
                    <span v-on="on"><v-icon>mdi-chevron-down</v-icon></span>
                </template>
                <v-list>
                    <v-list-item @click="">
                        <v-list-item-icon  class="mr-2"><v-icon>mdi-account</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Profil Saya</v-list-item-title></v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="">
                        <v-list-item-icon class="mr-2"><v-icon color="red">mdi-power</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title class="red--text">Keluar</v-list-item-title></v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </span>
    </div>
</v-app-bar>