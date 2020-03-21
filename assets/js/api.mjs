import axios from 'https://unpkg.com/axios/dist/axios.min.js'

const api = {
    apiLogin(nim,password) {
        const data = new FormData()
        data.append('nim',nim)
        data.append('passowrd',password)

        return new Promise((resolve, reject) => {
            axios.post('http://localhost:8000/api/User', data)
                .then(response => {
                    (response.data.status) ? resolve(response.data.data) : reject("NIM atau password Salah")
                }) .catch(err => {
                    console.log(err)
                    reject('Sistem Error')
                })
        })
    }
}

export default api