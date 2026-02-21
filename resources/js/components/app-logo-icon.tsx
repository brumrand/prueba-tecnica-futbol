import type { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg {...props} viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="21" r="19" fill="white" stroke="currentColor" strokeWidth="1.5" />

            <path
                d="M20 14L25.5 18L23.5 24.5H16.5L14.5 18L20 14Z"
                stroke="currentColor"
                strokeWidth="1.2"
                fill="none"
            />

            <path
                d="M20 14V2M25.5 18L36 14.5M23.5 24.5L31 35M16.5 24.5L9 35M14.5 18L4 14.5"
                stroke="currentColor"
                strokeWidth="1.2"
            />

            <path d="M8 6.5C12 3.5 28 3.5 32 6.5" stroke="currentColor" strokeWidth="1.2" />
            <path d="M37 28C34 35 28 39 20 40" stroke="currentColor" strokeWidth="1.2" />
            <path d="M3 28C6 35 12 39 20 40" stroke="currentColor" strokeWidth="1.2" />
        </svg>
    );
}
