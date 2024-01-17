import { Route, Routes } from 'react-router-dom'
import ErrorPage from './components/errorPage/ErrorPage'
import Home from './components/home/Home'
import RegisterPage from './components/registerPage/RegisterPage'
import LoginPage from './components/loginPage/LoginPage'
import CreateCourse from './components/createCourse/createCourse'

function App() {

  return (
    <Routes>
      <Route path="/login" element={<LoginPage />} />
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/" element={<Home />} />
      <Route path="*" element={<ErrorPage />} />
      <Route path="/create-course" element={<CreateCourse />} />
    </Routes>
  )
}

export default App
