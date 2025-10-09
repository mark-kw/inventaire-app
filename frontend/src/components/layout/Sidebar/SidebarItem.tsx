import type { JSX, SVGProps } from "react";
import type { IconName, NavItem } from "./navConfig";
import { NavLink } from "react-router-dom";

type Props = NavItem;


type SvgProps = SVGProps<SVGSVGElement>;
type IconComponent = (props: SvgProps) => JSX.Element;
type IconMap = Record<IconName, IconComponent>;

const Icons: IconMap = {
    calendar: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <rect x="3" y="4" width="18" height="17" rx="3" />
            <path d="M16 2v4M8 2v4M3 10h18" fill="none" stroke="currentColor" strokeWidth="1.7" />
        </svg>
    ),
    plan: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <path d="M3 6l7-3 7 3 4-2v16l-7 3-7-3-4 2V6z" fill="none" stroke="currentColor" strokeWidth="1.7" />
            <path d="M10 3v16M17 6v16" fill="none" stroke="currentColor" strokeWidth="1.3" />
        </svg>
    ),
    doc: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" fill="none" stroke="currentColor" strokeWidth="1.7" />
            <path d="M15 2v6h6" fill="none" stroke="currentColor" strokeWidth="1.5" />
        </svg>
    ),
    check: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" strokeWidth="1.7" />
            <path d="M8 12l3 3 5-6" fill="none" stroke="currentColor" strokeWidth="1.7" strokeLinecap="round" />
        </svg>
    ),
    status: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <rect x="3" y="11" width="4" height="10" rx="1" />
            <rect x="10" y="7" width="4" height="14" rx="1" />
            <rect x="17" y="3" width="4" height="18" rx="1" />
        </svg>
    ),
    box: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <path d="M3 7l9-4 9 4-9 4-9-4zM3 7v10l9 4 9-4V7" fill="none" stroke="currentColor" strokeWidth="1.7" />
        </svg>
    ),
    invoice: (props) => (
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" {...props}>
            <path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z" fill="none" stroke="currentColor" strokeWidth="1.7" />
            <path d="M8 7h8M8 11h8M8 15h6" fill="none" stroke="currentColor" strokeWidth="1.5" />
        </svg>
    ),
};

export default function SidebarItem({
    icon,
    label,
    to,
    badge,
    trailing,
}: Props): JSX.Element {
    const Icon = Icons[icon];

    return (
        <NavLink
            to={to}
            className={({ isActive }) => `sb-item ${isActive ? "is-active" : ""}`}
        >
            <span className="sb-item__icon" aria-hidden="true">
                <Icon />
            </span>

            <span className="sb-item__label">{label}</span>

            {typeof badge === "number" && (
                <span
                    className={`sb-item__badge ${badge > 0 ? "show" : ""}`}
                    aria-label={`${badge} nouveaux`}
                >
                    {badge}
                </span>
            )}

            {trailing && <span className="sb-item__trail">{trailing}</span>}
        </NavLink>
    );
}
