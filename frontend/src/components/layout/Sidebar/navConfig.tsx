// src/ui/navigation/navConfig.ts

export type IconName =
    | "calendar"
    | "plan"
    | "doc"
    | "check"
    | "status"
    | "box"
    | "invoice";

export type NavItem = {
    id: string;
    label: string;
    icon: IconName;
    to: string;
    badge?: number;
    trailing?: string;
};

export type NavSection = {
    heading: string;
    items: NavItem[];
};

export const navSections: NavSection[] = [
    {
        heading: "TABLEAU DE BORD",
        items: [
            { id: "dashboard", label: "Tableau de bord", icon: "calendar", to: "/dashboard" }
        ],
    },
    {
        heading: "GESTION DES CHAMBRES",
        items: [
            { id: "planning", label: "Planning Chambres", icon: "plan", to: "/planning", badge: 0 },
            { id: "reservations", label: "Réservations", icon: "doc", to: "/reservations" },
            { id: "check", label: "Check-in/out", icon: "check", to: "/check" },
            { id: "etat", label: "Etat des Chambres", icon: "status", to: "/status" },
        ],
    },
    {
        heading: "RESTAURANT & BAR",
        items: [{ id: "inventaire", label: "Inventaire", icon: "box", to: "/inventaire" }],
    },
    {
        heading: "FACTURATION",
        items: [{ id: "facturation", label: "Facturation", icon: "invoice", to: "/facturation", trailing: "›" }],
    },
];

