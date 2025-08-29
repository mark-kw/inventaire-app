// src/components/layout/Layout/Layout.tsx
import { Outlet } from "react-router-dom";
import { Sidebar } from "../Sidebar";

export default function Layout() {
    return (
        <div className="min-h-screen grid grid-cols-[auto_1fr]">
            <Sidebar />

            <div className="flex min-h-screen flex-col">
                <header className="h-14 border-b bg-background/60 backdrop-blur flex items-center px-4">
                    <h1 className="text-sm font-medium">Gestion des chambres</h1>
                </header>

                <main className="flex-1 overflow-y-auto p-6">
                    <Outlet />
                </main>
            </div>
        </div>
    );
}
