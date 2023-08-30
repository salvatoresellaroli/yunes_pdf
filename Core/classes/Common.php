<?php
abstract class errore
{
    const Sessione = -100003;
    const Generico = -100000;
    const Success = 1;
    const Info = 5;
}

abstract class controllerList
{
    const day = "reportGiornaliero";
    const week = "reportSettimanale";
    const month = "reportMensile";
    const demo7Day = "demo7Day";
    const demoFine = "demoFine";
    const ivrFine = "fineIVR";
    const metaIVR = "metaIVR";
    const consumiDAY = "consumiGiornalieri";
    const userExpired = "userExpired";
}

if ($isDEBUG === true) {
    abstract class schemaDB
    {
        const raiseup = "pre";
        const voip = "pre_voip";
        const stats = "pre_voip";
    }
} else {
    abstract class schemaDB
    {
        const raiseup = "pro";
        const voip = "voip";
        const stats = "stats";
    }
}
