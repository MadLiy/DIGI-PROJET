import { Route, Routes } from 'react-router-dom'
import ErrorPage from './components/errorPage/ErrorPage'
import Home from './components/home/Home'
import RegisterPage from './components/registerPage/RegisterPage'

function App() {

  return (
    <Routes>
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/" element={<Home />} />
      <Route path="*" element={<ErrorPage />} />
    </Routes>
  )
}

export default App
