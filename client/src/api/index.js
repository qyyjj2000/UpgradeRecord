import axios from 'axios'

const api = axios.create({
  // baseURL: 'http://localhost/Record/server/api.php?',
  baseURL: 'http://localhost/UpgradeRecord/server/',

  timeout: 5000
})

export default api