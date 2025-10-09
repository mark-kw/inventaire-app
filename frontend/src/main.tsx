import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import { attachInterceptors } from "./services/attachInterceptors";
import ProtectedRoute from "./components/ProtectedRoute";

// Layout + pages
import Layout from "./components/layout/Layout/Layout";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import Rooms from "./pages/Rooms";
// import Reservations from "./pages/Reservations";

import "./index.css";
import Planning from "./pages/Planning";
import Check from "./pages/Check";
import RoomStatus from "./pages/RoomStatus";

attachInterceptors();

ReactDOM.createRoot(document.getElementById("root")!).render(
  <React.StrictMode>
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route
            path="/"
            element={
              <ProtectedRoute>
                <Layout />
              </ProtectedRoute>
            }
          >
            <Route index element={<Dashboard />} />
            <Route path="planning" element={<Planning />} />
            <Route path="reservations" element={<Rooms />} />
            <Route path="check" element={<Check />} />
            <Route path="status" element={<RoomStatus />} />
          </Route>
          <Route path="*" element={<Navigate to="/" replace />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  </React.StrictMode>
);
