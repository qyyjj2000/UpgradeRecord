import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost/Record/server/api.php',
  timeout: 5000
})

export default api