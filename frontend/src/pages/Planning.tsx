
import { useEffect, useState } from "react";
import api from "../services/api";
import { Scheduler, type SchedulerProperties } from "smart-webcomponents-react/scheduler";
import "smart-webcomponents-react/source/styles/smart.default.css";

type guest = {
    id: string,
    firstName: string,
    lastName: string,
    email: string,
    phone: string,
    nationality: string,
    idType: string,
    idNumber: string
}

type room = {
    number: string,
    name: string,
    status: string,
    capicityAdults: number,
    capacityChildren: number,
    nightPrice: string,
    currency: string
}

type reservations = {
    guest: guest,
    room: room,
    status: string,
    arrivalDate: string,
    departureDate: string,
}

const Planning = () => {

    const [reservations, setReservations] = useState<reservations[]>([])
    const [loading, setLoading] = useState(true)
    const [dataSource, setDataSource] = useState<any[]>([]);

    // const dataSource = [
    //     {
    //         label: "Réservation Zara",
    //         dateStart: "2025-08-24T14:00:00",
    //         dateEnd: "2025-08-26T12:00:00",
    //         allDay: true,
    //     },
    // ];

    // Options du scheduler (fortement typées grâce à TypeScript)



    useEffect(() => {
        (async () => {
            try {
                const { data } = await api.get("/api/reservations?pagination=false");
                setReservations(data["hydra:member"] ?? data);
                const mapped = (data["hydra:member"] as reservations[]).map((res) => {
                    return {
                        "label": res.room.name,
                        "dateStart": res.arrivalDate,
                        "dateEnd": res.departureDate,
                        "allDay": true
                    }
                })
                setDataSource(mapped)
            } finally { setLoading(false); }
        })();
    }, []);

    const schedulerProps: SchedulerProperties = {
        view: "timelineWeek",
        dateCurrent: "2025-08-18",
        dataSource: dataSource,
    };

    console.log(reservations)

    if (loading) return <div className="p-4">Chargement…</div>;
    return (
        <div style={{ height: "90vh" }}>
            <Scheduler {...schedulerProps} id="scheduler" />
        </div>
    );
}

export default Planning;
