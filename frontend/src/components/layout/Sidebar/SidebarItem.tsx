

import { NavLink } from "react-router-dom";


export interface SidebarItemProps {
    to: string;
    label: string;
    icon: React.ComponentType<{ className?: string }>
}


export default function SidebarItem({ to, label, icon: Icon }: SidebarItemProps) {
    return (
        <NavLink
            to={to}
            end
            className={({ isActive }) =>
                `flex items-center gap-3 px-4 py-2 rounded-md transition-colors 
                   ${isActive ? "bg-gray-700" : "hover:bg-gray-800"}`
            }
        >
            <Icon className="h-5 w-5" />
            <span>{label}</span>
        </NavLink>
    )
}