import { ref } from "vue"

const fields = ref([])

export function useFieldsStore() {
    const loadFields = async () => {
        const response = await fetch("/api/field")
        const body = await response.json()

        fields.value = body.data
    }

    const deleteField = async (id) => {
        await fetch(`/api/field/${id}`, { method: "DELETE" })

        loadFields()
    }

    const addField = async (title, type) => {
        await fetch('api/field', {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ "title": title, "type": type })
        });

        loadFields()
    }

    return {
        loadFields,
        deleteField,
        addField,
        fields
    }
}
