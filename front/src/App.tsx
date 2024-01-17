import { useState } from "react";
import { Route, Routes } from "react-router-dom";
import ErrorPage from "./components/errorPage/ErrorPage";
import Home from "./components/home/Home";
import RegisterPage from "./components/registerPage/RegisterPage";
import LoginPage from "./components/loginPage/LoginPage";
import UserInterface from "./interfaces/UserInterface";

function App() {
  const [user, setUser] = useState<UserInterface | undefined>();

  return (
    <Routes>
      <Route path="/login" element={<LoginPage setUser={setUser} />} />
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/" element={<Home user={user} />} />
      <Route path="*" element={<ErrorPage />} />
    </Routes>
  );
}

export default App;
