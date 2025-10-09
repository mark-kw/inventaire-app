import { navSections } from "./navConfig";
import SidebarItem from "./SidebarItem";
import "./sidebar.css";

type Props = { width?: number };

export default function Sidebar({ width = 280 }: Props) {
    return (
        <aside
            className="sidebar"
            style={{ width }}
            aria-label="Navigation principale"
        >
            <div className="sb-header">
                <div className="brand">
                    <span className="brand__logo" aria-hidden="true">k</span>
                    <span className="brand__text">KAFLAND</span>
                </div>
            </div>

            <nav className="sb-nav">
                {navSections.map((section) => (
                    <div className="sb-section" key={section.heading}>
                        <div className="sb-section__title">{section.heading}</div>
                        <div role="list" className="sb-section__list">
                            {section.items.map((item) => (
                                <SidebarItem key={item.id} {...item} />
                            ))}
                        </div>
                    </div>
                ))}
            </nav>

            <div className="sb-footer">
                <a className="sb-profile" href="/profile">
                    <span className="sb-avatar" aria-hidden="true">•</span>
                    <span className="sb-profile__name">Admin</span>
                    <span className="sb-profile__role">Gestionnaire</span>
                </a>
            </div>
        </aside>
    );
}
