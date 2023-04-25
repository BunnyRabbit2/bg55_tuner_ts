import React from "react";

import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import EntryForm from "../components/EntryForm";

export default function Main() {
  return (
    <>
      <Navbar />
      <main>
        <EntryForm />
      </main>
      <Footer />
    </>
  );
}
