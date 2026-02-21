
import { Venue } from './venue';

export interface Team {
    id: number;
    name: string;
    logo: string;
    country: string;
    founded: number;
    venue: Venue | null;
}
