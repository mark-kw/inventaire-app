export type Room = {
    id: string;
    label: string;         // "Ch. 101"
    type: "single" | "double" | "suite";
    capacity: number;
    priceCfa: number;
    status?: "Libre" | "Occupée";
};

export type BookingStatus = "reserved" | "arrivee" | "depart" | "occupied" | "blocked";

export type Booking = {
    id: string;
    roomId: string;
    guestName: string;
    startDate: string;   // YYYY-MM-DD (inclusive)
    endDate: string;     // YYYY-MM-DD (exclusive)
    status: BookingStatus;
};
