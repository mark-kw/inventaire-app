

import { Home, BedDouble } from "lucide-react";
import SidebarItem from "./SidebarItem";

const items = [
    { to: "/", label: "Dashboard", icon: Home },
    { to: "/rooms", label: "Rooms", icon: BedDouble }
]

// interface SidebarProps {
//     collapsed?: boolean;
//     onToggle?: () => void;
// }

export default function Sidebar({ }) {

    return (
        <aside className="h-screen w-64 bg-gray-900 text-white flex flex-col">
            <div className="p-4 text-xl font-bold">My App</div>
            <nav className="flex-1">
                <ul className="space-y-2">
                    {items.map((item) => (
                        <li key={item.to}>
                            <SidebarItem  {...item} />
                        </li>
                    ))}
                </ul>
            </nav>
        </aside>
    )
}