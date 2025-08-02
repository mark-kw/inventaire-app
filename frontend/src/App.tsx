import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
// import Dashboard from "./pages/Dashboard"; // à venir

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
