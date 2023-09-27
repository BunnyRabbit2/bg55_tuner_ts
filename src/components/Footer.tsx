import React from "react";

export default function Footer() {
  return (
    <footer className="footer container mx-auto items-center p-4 bg-neutral text-neutral-content">
      <aside className="items-center grid-flow-col">
        <p>Copyright © 2023 - All right reserved</p>
      </aside>
      <nav className="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
        <p>github link</p>
      </nav>
    </footer>
  );
}
